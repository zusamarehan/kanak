<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\Api\DonorListController;
use App\Http\Controllers\Api\DisbursementStatsController;
use App\Http\Controllers\Api\RecipientListController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/donation-stats', [DonationStatsController::class, 'index']);
Route::get('/donors', [DonorListController::class, 'index']);

Route::get('/disbursement-stats', [DisbursementStatsController::class, 'index']);
Route::get('/recipients', [RecipientListController::class, 'index']);
