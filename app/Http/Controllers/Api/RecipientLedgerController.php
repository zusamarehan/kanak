<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipientLedgerController extends Controller
{
    public function show($id)
    {
        $recipient = DB::table('recipients')->where('id', $id)->first();
        
        if (!$recipient) {
            return response()->json(['success' => false, 'message' => 'Recipient not found'], 404);
        }

        // Fetch disbursements (Debits) - only returnable ones or all? 
        // User asked for the Returnable Roster specifically, so let's stick to non-zakat/non-help for the ledger too usually, 
        // OR show all but mark them. Highlighting returnable is better.
        $disbursements = DB::table('disbursements')
            ->where('recipient_id', $id)
            ->where('is_zakat', false)
            ->where('is_help', false)
            ->select('id', 'amount', 'paid_on as date', 'notes', DB::raw("'debit' as type"))
            ->get();

        $repayments = DB::table('repayments')
            ->where('recipient_id', $id)
            ->select('id', 'amount', 'paid_on as date', 'notes', DB::raw("'credit' as type"))
            ->get();

        $ledger = $disbursements->concat($repayments)
            ->sortBy('date')
            ->values()
            ->map(function($item, $index) use (&$balance) {
                if ($item->type === 'debit') {
                    $balance += $item->amount;
                } else {
                    $balance -= $item->amount;
                }
                $item->running_balance = $balance;
                return $item;
            });

        return response()->json([
            'success' => true,
            'data' => [
                'recipient' => $recipient,
                'ledger' => $ledger,
                'final_balance' => $balance
            ]
        ]);
    }
}
