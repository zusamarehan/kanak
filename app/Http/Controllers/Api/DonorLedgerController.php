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
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('created_at')
            ->get()
            ->map(function($item) {
                // Formatting for the UI - since we only have month/year, we'll use that as the reference date
                $item->date = "{$item->year}-" . str_pad($item->month, 2, '0', STR_PAD_LEFT) . "-01";
                $item->type = 'credit'; // Foundation perspective: Credit (money in)
                $item->description = "Donation for {$item->month}/{$item->year}";
                return $item;
            });

        return response()->json([
            'success' => true,
            'data' => [
                'donor' => $donor,
                'ledger' => $donations,
                'total_contributed' => $donations->sum('amount')
            ]
        ]);
    }
}
