<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonorLedgerController extends Controller
{
    public function show($id)
    {
        $donor = DB::table('donors')->where('id', $id)->first();
        
        if (!$donor) {
            return response()->json(['success' => false, 'message' => 'Donor not found'], 404);
        }

        // 1. Fetch Normal Donations
        $donations = DB::table('donations')
            ->where('donor_id', $id)
            ->where('amount', '>', 0)
            ->select('id', 'amount', 'month', 'year', 'created_at')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Donation',
                    'date' => "{$item->year}-" . str_pad($item->month, 2, '0', STR_PAD_LEFT) . "-01",
                    'description' => "Contribution",
                    'raw_date' => $item->created_at
                ];
            });

        // 2. Fetch Zakat Collections
        $zakat = DB::table('zakat_collections')
            ->where('donor_id', $id)
            ->where('amount', '>', 0)
            ->select('id', 'amount', 'collected_on', 'created_at')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Zakat',
                    'date' => $item->collected_on,
                    'description' => "Zakat Collection",
                    'raw_date' => $item->created_at
                ];
            });

        // 3. Combine and Sort (Most recent first)
        $ledger = $donations->concat($zakat)
            ->sortByDesc(function($item) {
                return $item['date'] . $item['raw_date'];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'donor' => $donor,
                'ledger' => $ledger,
                'total_contributed' => $ledger->sum('amount')
            ]
        ]);
    }
}
