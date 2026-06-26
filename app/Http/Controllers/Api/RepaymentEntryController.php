<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RepaymentEntryController extends Controller
{
    /**
     * Get all recipients for the dropdown.
     */
    public function recipients()
    {
        $recipients = DB::table('recipients')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $recipients
        ]);
    }

    /**
     * Store a new repayment entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|integer|exists:recipients,id',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date_format:Y-m-d',
            'type' => 'required|in:regular,bad_debt',
        ]);

        $id = DB::table('repayments')->insertGetId([
            'recipient_id' => $validated['recipient_id'],
            'amount' => $validated['amount'],
            'paid_on' => $validated['entry_date'],
            'is_bad_debt' => $validated['type'] === 'bad_debt' ? 1 : 0,
            'created_at' => now(),
        ]);

        $recipient = DB::table('recipients')->where('id', $validated['recipient_id'])->first();

        return response()->json([
            'success' => true,
            'message' => 'Repayment recorded successfully.',
            'data' => [
                'id' => $id,
                'recipient_name' => $recipient->name,
                'amount' => (float) $validated['amount'],
                'paid_on' => $validated['entry_date'],
                'type' => $validated['type'],
            ]
        ], 201);
    }
}
