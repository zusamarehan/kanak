<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Api\OverviewController::class, 'show'])->name('overview');
Route::get('/donations', function () {
    return view('dashboard');
})->name('donations');

Route::get('/disbursements', function () {
    return view('disbursements-dashboard');
})->name('disbursements');

// Alias for typo support as requested
Route::get('/disburements', function () {
    return view('disbursements-dashboard');
});

