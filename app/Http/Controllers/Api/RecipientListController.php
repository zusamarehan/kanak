<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RecipientListController extends Controller
{
    /**
     * Get a list of all recipients and their total number of disbursements / amount
     * filtered by date.
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

        // Helper to build the query
        $buildQuery = function($whereColumn, $value) use ($startDate, $endDate) {
            return DB::table('recipients')
                ->join('disbursements', function($join) use ($startDate, $endDate, $whereColumn, $value) {
                    $join->on('recipients.id', '=', 'disbursements.recipient_id')
                         ->where('disbursements.'.$whereColumn, $value);
                    
                    if ($startDate && $endDate) {
                        $join->whereBetween('disbursements.paid_on', [$startDate, $endDate]);
                    }
                })
                ->select(
                    'recipients.id',
                    'recipients.name',
                    'recipients.type',
                    DB::raw('COUNT(disbursements.id) as total_disbursements_count'),
                    DB::raw('COALESCE(SUM(disbursements.amount), 0) as total_disbursed_amount')
                )
                ->groupBy('recipients.id', 'recipients.name', 'recipients.type')
                ->orderByDesc('total_disbursed_amount')
                ->get();
        };

        $zakatRecipients = $buildQuery('is_zakat', true);
        $grantRecipients = $buildQuery('is_help', true);
        
        // Custom query for Normal (Returnable) to exclude both Zakat and Help
        $normalRecipients = DB::table('recipients')
            ->join('disbursements', function($join) use ($startDate, $endDate) {
                $join->on('recipients.id', '=', 'disbursements.recipient_id')
                     ->where('disbursements.is_zakat', false)
                     ->where('disbursements.is_help', false);
                
                if ($startDate && $endDate) {
                    $join->whereBetween('disbursements.paid_on', [$startDate, $endDate]);
                }
            })
            ->select(
                'recipients.id',
                'recipients.name',
                'recipients.type',
                DB::raw('COUNT(DISTINCT disbursements.id) as total_disbursements_count'),
                DB::raw('SUM(disbursements.amount) as total_disbursed_amount'),
                DB::raw('(SELECT COALESCE(SUM(amount), 0) FROM repayments WHERE recipient_id = recipients.id) as total_repaid_amount'),
                DB::raw('(SELECT COALESCE(SUM(amount), 0) FROM disbursements WHERE recipient_id = recipients.id AND is_zakat = 0 AND is_help = 0) as historical_disbursed_amount')
            )
            ->groupBy('recipients.id', 'recipients.name', 'recipients.type')
            ->orderByDesc('total_disbursed_amount')
            ->get()
            ->map(function($item) {
                $item->outstanding_amount = $item->historical_disbursed_amount - $item->total_repaid_amount;
                return $item;
            });

        return response()->json([
            'success' => true,
            'data' => [
                'zakat' => $zakatRecipients,
                'normal' => $normalRecipients,
                'grants' => $grantRecipients,
            ],
            'meta' => [
                'total_zakat_recipients' => $zakatRecipients->count(),
                'total_normal_recipients' => $normalRecipients->count(),
                'total_grant_recipients' => $grantRecipients->count(),
                'filtered_by_date' => ($startDate && $endDate) ? true : false,
                'start_date' => $startDate ? $startDate->toDateString() : null,
                'end_date' => $endDate ? $endDate->toDateString() : null,
            ]
        ]);
    }
}
