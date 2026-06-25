<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DonationEntryController extends Controller
{
    /**
     * Get all donors for the dropdown.
     */
    public function donors()
    {
        $donors = DB::table('donors')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $donors
        ]);
    }

    /**
     * Store a new donation entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_id' => 'required|integer|exists:donors,id',
            'amount' => 'required|numeric|min:0.01',
            'entry_date' => 'required|date_format:Y-m-d',
        ]);

        $date = Carbon::createFromFormat('Y-m-d', $validated['entry_date']);

        $id = DB::table('donations')->insertGetId([
            'donor_id' => $validated['donor_id'],
            'amount' => $validated['amount'],
            'month' => $date->month,
            'year' => $date->year,
            'created_at' => now(),
        ]);

        $donor = DB::table('donors')->where('id', $validated['donor_id'])->first();

        return response()->json([
            'success' => true,
            'message' => 'Donation recorded successfully.',
            'data' => [
                'id' => $id,
                'donor_name' => $donor->name,
                'amount' => (float) $validated['amount'],
                'month' => $date->month,
                'year' => $date->year,
            ]
        ], 201);
    }
}
