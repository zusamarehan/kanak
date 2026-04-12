<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\Api\DonorListController;
use App\Http\Controllers\Api\DisbursementStatsController;
use App\Http\Controllers\Api\RecipientListController;
use App\Http\Controllers\Api\RecipientLedgerController;
use App\Http\Controllers\Api\DonorLedgerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/donation-stats', [DonationStatsController::class, 'index']);
Route::get('/donors', [DonorListController::class, 'index']);
Route::get('/donors/{id}/ledger', [DonorLedgerController::class, 'show']);

Route::get('/disbursement-stats', [DisbursementStatsController::class, 'index']);
Route::get('/recipients', [RecipientListController::class, 'index']);
Route::get('/recipients/{id}/ledger', [RecipientLedgerController::class, 'show']);
