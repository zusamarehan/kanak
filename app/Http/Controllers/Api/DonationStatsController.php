<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonationStatsController extends Controller
{
    /**
     * Get donation statistics (total amount, total donations, total donors).
     * 
     * Accepts date filter via query parameters:
     * - "start_date" (e.g. 2026-03-01) and "end_date"
     * - OR "date_range" string (e.g. "march 1 2026 to march 10 2026")
     */
    public function index(Request $request)
    {
        // Enforce strict date format (Y-m-d) to prevent guesswork
        $validated = $request->validate([
            'start_date' => 'nullable|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d',
        ]);

        $startDateStr = $validated['start_date'] ?? null;
        $endDateStr = $validated['end_date'] ?? null;
        
        $startDate = null;
        $endDate = null;

        if ($startDateStr && $endDateStr) {
            // Carbon parses Y-m-d cleanly without guesswork
            $startDate = Carbon::createFromFormat('Y-m-d', $startDateStr)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $endDateStr)->endOfDay();
        }

        // Base queries
        // Exclude all 0.00 amounts so we ONLY count real donations and real given money
        $donationsQuery = DB::table('donations')->where('amount', '>', 0);
        $zakatQuery = DB::table('zakat_collections')->where('amount', '>', 0);

        // Apply date scope if we successfully parsed dates
        if ($startDate && $endDate) {
            $startPeriod = $startDate->year * 100 + $startDate->month; // e.g. 202403
            $endPeriod = $endDate->year * 100 + $endDate->month;       // e.g. 202603

            // Filter donations using the actual `year` and `month` columns
            $donationsQuery->whereRaw('(year * 100 + month) >= ?', [$startPeriod])
                           ->whereRaw('(year * 100 + month) <= ?', [$endPeriod]);

            // Filter Zakat collections using `collected_on` date column
            $zakatQuery->whereBetween('collected_on', [$startDate->toDateString(), $endDate->toDateString()]);
        }

        // Fetch datasets
        $donationsDataset = $donationsQuery->get();
        $zakatDataset = $zakatQuery->get();
        
        // 1. Total normal donations
        $totalCollectedAmount = $donationsDataset->sum('amount');
        $totalDonationsCount = $donationsDataset->count();
        $totalNormalDonors = $donationsDataset->unique('donor_id')->count();

        // 2. Total Zakat collections
        $totalZakatAmount = $zakatDataset->sum('amount');
        $totalZakatCount = $zakatDataset->count();
        $totalZakatDonors = $zakatDataset->unique('donor_id')->count();

        // 3. Combined Stats
        $allUniqueDonors = $donationsDataset->concat($zakatDataset)->unique('donor_id')->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_collected_amount' => (float) $totalCollectedAmount,
                'total_donations_count' => $totalDonationsCount,
                'total_normal_donors_count' => $totalNormalDonors,
                
                'total_zakat_amount' => (float) $totalZakatAmount,
                'total_zakat_count' => $totalZakatCount,
                'total_zakat_donors_count' => $totalZakatDonors,

                'total_unique_donors_count' => $allUniqueDonors,
            ],
            'meta' => [
                'filtered_by_date' => ($startDate && $endDate) ? true : false,
                'start_date' => $startDate ? $startDate->toDateTimeString() : null,
                'end_date' => $endDate ? $endDate->toDateTimeString() : null,
            ]
        ]);
    }
}
