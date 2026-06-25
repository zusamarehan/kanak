<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonorLedgerController extends Controller
{
    public function show($id)
    {
        $donor = DB::table('donors')->where('id', $id)->first();

        if (!$donor) {
            return response()->json([
                'success' => false,
                'message' => 'Donor not found'
            ], 404);
        }

        $donations = DB::table('donations')
            ->where('donor_id', $id)
            ->where('amount', '>', 0)
            ->select('id', 'amount', 'month', 'year', 'created_at')
            ->get()
            ->map(function ($item) {

                $date = Carbon::parse($item->created_at);

                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Donation',
                    'date' => $date->toDateString(),
                    'timestamp' => $date->timestamp,
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

                // IMPORTANT: use collected_on (actual business date), not created_at
                $date = Carbon::parse($item->collected_on);

                return [
                    'id' => $item->id,
                    'amount' => (float) $item->amount,
                    'type' => 'Zakat',
                    'date' => $date->toDateString(),
                    'timestamp' => $date->timestamp,
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
