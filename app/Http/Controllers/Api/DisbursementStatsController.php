<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DisbursementStatsController extends Controller
{
    /**
     * Get disbursement statistics (total amount, total disbursements, total recipients).
     * 
     * Accepts date filter via query parameters:
     * - "start_date" (e.g. 2026-03-01) and "end_date"
     */
    public function index(Request $request)
    {
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

        // Base query
        $query = DB::table('disbursements');

        if ($startDate && $endDate) {
            $query->whereBetween('paid_on', [$startDate, $endDate]);
        }

        $dataset = $query->get();
        
        $totalReturnable = $dataset->where('is_zakat', false)->where('is_help', false)->sum('amount');
        $totalZakat = $dataset->where('is_zakat', true)->sum('amount');
        $totalGrants = $dataset->where('is_help', true)->sum('amount');

        return response()->json([
            'success' => true,
            'data' => [
                'total_returnable' => (float) $totalReturnable,
                'total_zakat' => (float) $totalZakat,
                'total_grants' => (float) $totalGrants,
                'total_disbursed_amount' => (float) $dataset->sum('amount'),
                'total_disbursements_count' => $dataset->count(),
                'total_recipients_count' => $dataset->unique('recipient_id')->count(),
            ],
            'meta' => [
                'filtered_by_date' => ($startDate && $endDate) ? true : false,
                'start_date' => $startDate ? $startDate->toDateString() : null,
                'end_date' => $endDate ? $endDate->toDateString() : null,
            ]
        ]);
    }
}
