<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\Api\DonorListController;
use App\Http\Controllers\Api\DisbursementStatsController;
use App\Http\Controllers\Api\RecipientListController;
use App\Http\Controllers\Api\RecipientLedgerController;
use App\Http\Controllers\Api\DonorLedgerController;
use App\Http\Controllers\Api\DonationEntryController;
use App\Http\Controllers\Api\DisbursementEntryController;
use App\Http\Controllers\Api\RepaymentEntryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/donation-stats', [DonationStatsController::class, 'index']);
Route::get('/donors', [DonorListController::class, 'index']);
Route::get('/donors/{id}/ledger', [DonorLedgerController::class, 'show']);

Route::get('/donors-list', [DonationEntryController::class, 'donors']);
Route::post('/donations', [DonationEntryController::class, 'store']);

Route::get('/disbursement-stats', [DisbursementStatsController::class, 'index']);
Route::get('/recipients', [RecipientListController::class, 'index']);
Route::get('/recipients/{id}/ledger', [RecipientLedgerController::class, 'show']);

Route::get('/recipients-list', [DisbursementEntryController::class, 'recipients']);
Route::post('/disbursements', [DisbursementEntryController::class, 'store']);
Route::post('/repayments', [RepaymentEntryController::class, 'store']);
Route::get('/overview', [\App\Http\Controllers\Api\OverviewController::class, 'index']);
