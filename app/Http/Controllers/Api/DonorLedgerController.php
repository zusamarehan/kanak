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

        $donations = DB::table('donations')
            ->where('donor_id', $id)
            ->where('amount', '>', 0)
            ->select('id', 'amount', 'month', 'year', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Donation',
                    'date' => $item->created_at->toDateString(),
                    'timestamp' => strtotime($item->created_at),
                    'description' => 'Contribution',
                    'raw_date' => $item->created_at,
                ];
            });

        $zakat = DB::table('zakat_collections')
            ->where('donor_id', $id)
            ->where('amount', '>', 0)
            ->select('id', 'amount', 'collected_on', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Zakat',
                    'date' => $item->created_at->toDateString(),
                    'timestamp' => strtotime($item->created_at),
                    'description' => 'Zakat Collection',
                    'raw_date' => $item->created_at,
                ];
            });

        $ledger = $donations
            ->concat($zakat)
            ->sortByDesc('timestamp')
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'donor' => $donor,
                'ledger' => $ledger,
                'total_contributed' => $ledger->sum('amount'),
            ]
        ]);
    }
}
