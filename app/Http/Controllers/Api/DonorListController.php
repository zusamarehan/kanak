<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonorListController extends Controller
{
    /**
     * Get a list of all donors and their total number of donations / amount
     * filtered by the exact same date structure.
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
            $startDate = Carbon::createFromFormat('Y-m-d', $startDateStr)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $endDateStr)->endOfDay();
        }

        // We use a LEFT JOIN so all donors are listed, even if they had 0 donations 
        // in the specific date range. If you only want donors WHO donated, we could just use `join()`.
        $query = DB::table('donors')
            ->leftJoin('donations', function($join) use ($startDate, $endDate) {
                // Ignore the $0.00 automated ledgers
                $join->on('donors.id', '=', 'donations.donor_id')
                     ->where('donations.amount', '>', 0);
                     
                // Apply the exact same year/month logic to the join
                if ($startDate && $endDate) {
                    $startPeriod = $startDate->year * 100 + $startDate->month;
                    $endPeriod = $endDate->year * 100 + $endDate->month;
                    
                    $join->whereRaw('(donations.year * 100 + donations.month) >= ?', [$startPeriod])
                         ->whereRaw('(donations.year * 100 + donations.month) <= ?', [$endPeriod]);
                }
            })
            ->select(
                'donors.id',
                'donors.name',
                DB::raw('COUNT(donations.id) as total_donations_count'),
                DB::raw('COALESCE(SUM(donations.amount), 0) as total_donated_amount')
            )
            ->groupBy('donors.id', 'donors.name')
            // Order by most donated amount at the top
            ->orderByDesc('total_donated_amount');

        $donors = $query->get();

        return response()->json([
            'success' => true,
            'data' => $donors,
            'meta' => [
                'total_donors_in_list' => $donors->count(),
                'filtered_by_date' => ($startDate && $endDate) ? true : false,
                'start_date' => $startDate ? $startDate->toDateTimeString() : null,
                'end_date' => $endDate ? $endDate->toDateTimeString() : null,
            ]
        ]);
    }
}
