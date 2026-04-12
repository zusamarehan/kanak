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

        // 1. Normal Donations Query
        $normalQuery = DB::table('donors')
            ->leftJoin('donations', function($join) use ($startDate, $endDate) {
                $join->on('donors.id', '=', 'donations.donor_id')
                     ->where('donations.amount', '>', 0);
                     
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
                DB::raw('COUNT(donations.id) as total_count'),
                DB::raw('COALESCE(SUM(donations.amount), 0) as total_amount')
            )
            ->groupBy('donors.id', 'donors.name')
            ->having('total_amount', '>', 0)
            ->orderByDesc('total_amount');

        // 2. Zakat Collections Query
        $zakatQuery = DB::table('donors')
            ->leftJoin('zakat_collections', function($join) use ($startDate, $endDate) {
                $join->on('donors.id', '=', 'zakat_collections.donor_id')
                     ->where('zakat_collections.amount', '>', 0);
                     
                if ($startDate && $endDate) {
                    $join->whereBetween('zakat_collections.collected_on', [$startDate->toDateString(), $endDate->toDateString()]);
                }
            })
            ->select(
                'donors.id',
                'donors.name',
                DB::raw('COUNT(zakat_collections.id) as total_count'),
                DB::raw('COALESCE(SUM(zakat_collections.amount), 0) as total_amount')
            )
            ->groupBy('donors.id', 'donors.name')
            ->having('total_amount', '>', 0)
            ->orderByDesc('total_amount');

        $normalDonors = $normalQuery->get();
        $zakatDonors = $zakatQuery->get();

        return response()->json([
            'success' => true,
            'data' => [
                'normal' => $normalDonors,
                'zakat' => $zakatDonors
            ],
            'meta' => [
                'filtered_by_date' => ($startDate && $endDate) ? true : false,
                'start_date' => $startDate ? $startDate->toDateTimeString() : null,
                'end_date' => $endDate ? $endDate->toDateTimeString() : null,
            ]
        ]);
    }
}
