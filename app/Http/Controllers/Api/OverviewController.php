<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OverviewController extends Controller
{
    /**
     * Get consolidated financial overview.
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

        // --- 1. MONEY IN: Collections (Donations + Zakat) ---
        $donationsQuery = DB::table('donations')->where('amount', '>', 0);
        $zakatCollQuery = DB::table('zakat_collections')->where('amount', '>', 0);

        if ($startDate && $endDate) {
            $startPeriod = $startDate->year * 100 + $startDate->month;
            $endPeriod = $endDate->year * 100 + $endDate->month;

            $donationsQuery->whereRaw('(year * 100 + month) >= ?', [$startPeriod])
                           ->whereRaw('(year * 100 + month) <= ?', [$endPeriod]);

            $zakatCollQuery->whereBetween('collected_on', [$startDate->toDateString(), $endDate->toDateString()]);
        }

        $donationsSum = $donationsQuery->sum('amount');
        $zakatCollectionsSum = $zakatCollQuery->sum('amount');

        // --- 2. MONEY IN: Repayments & Bad Debts ---
        $repaymentsQuery = DB::table('repayments')->where('amount', '>', 0);
        
        if ($startDate && $endDate) {
            $repaymentsQuery->whereBetween('paid_on', [$startDate->toDateString(), $endDate->toDateString()]);
        }

        $allRepayments = $repaymentsQuery->get();
        $actualRepaymentsSum = $allRepayments->where('is_bad_debt', 0)->sum('amount');
        $badDebtSum = $allRepayments->where('is_bad_debt', 1)->sum('amount');
        
        // Total In (User's definition: includes bad debt write-offs)
        $totalIn = $donationsSum + $zakatCollectionsSum + $actualRepaymentsSum + $badDebtSum;
        // Total Cash In (Liquid)
        $totalCashIn = $donationsSum + $zakatCollectionsSum + $actualRepaymentsSum;

        // --- 3. MONEY OUT: Disbursements ---
        $disbursementsQuery = DB::table('disbursements')->where('amount', '>', 0);

        if ($startDate && $endDate) {
            $disbursementsQuery->whereBetween('paid_on', [$startDate->toDateString(), $endDate->toDateString()]);
        }

        $disbursements = $disbursementsQuery->get();
        
        $loanDisbursements = $disbursements->where('is_zakat', 0)->where('is_help', 0)->sum('amount');
        $zakatGrants = $disbursements->where('is_zakat', 1)->sum('amount');
        $helpAids = $disbursements->where('is_help', 1)->sum('amount');
        
        $totalOut = $disbursements->sum('amount');

        // --- 4. POSITION & RECOVERY ---
        $netBalance = $totalCashIn - $totalOut; // Liquid cash balance
        
        // Recovery logic: 
        // Total Loaned (Money that was expected back)
        // We calculate this from all-time or filtered? 
        // For a true "Outstanding", we usually need all-time.
        // But if filtering, we show what happened in that period.
        
        // For "Outstanding", let's provide a lifetime figure if no filter, or period-specific.
        // Actually, "Outstanding" is usually a snapshot.
        $totalLoanedLifetime = DB::table('disbursements')->where('is_zakat', 0)->where('is_help', 0)->sum('amount');
        $totalRepaidLifetime = DB::table('repayments')->sum('amount'); // includes bad debts per user request for "resolved"
        $totalOutstandingLifetime = $totalLoanedLifetime - $totalRepaidLifetime;

        return response()->json([
            'success' => true,
            'data' => [
                'position' => [
                    'total_in' => (float)$totalIn, // Includes bad debt write-offs
                    'total_cash_in' => (float)$totalCashIn,
                    'total_out' => (float)$totalOut,
                    'net_balance' => (float)$netBalance,
                ],
                'inbound' => [
                    'donations' => (float)$donationsSum,
                    'zakat_collections' => (float)$zakatCollectionsSum,
                    'repayments' => (float)$actualRepaymentsSum,
                    'bad_debts' => (float)$badDebtSum,
                ],
                'outbound' => [
                    'loans' => (float)$loanDisbursements,
                    'zakat_grants' => (float)$zakatGrants,
                    'help_aids' => (float)$helpAids,
                ],
                'recovery' => [
                    'total_loaned' => (float)$totalLoanedLifetime,
                    'total_resolved' => (float)$totalRepaidLifetime,
                    'outstanding' => (float)max(0, $totalOutstandingLifetime),
                    'bad_debt_total' => (float)DB::table('repayments')->where('is_bad_debt', 1)->sum('amount')
                ]
            ],
            'meta' => [
                'filtered_by_date' => ($startDate && $endDate),
                'start_date' => $startDate ? $startDate->toDateString() : null,
                'end_date' => $endDate ? $endDate->toDateString() : null,
            ]
        ]);
    }

    /**
     * Show the overview page.
     */
    public function show()
    {
        return view('overview');
    }
}
