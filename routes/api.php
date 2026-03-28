<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DonationStatsController;
use App\Http\Controllers\Api\DonorListController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/donation-stats', [DonationStatsController::class, 'index']);
Route::get('/donors', [DonorListController::class, 'index']);
