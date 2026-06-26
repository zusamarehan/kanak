<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\Api\OverviewController::class, 'show'])->name('overview');
Route::get('/donations', function () {
    return view('dashboard');
})->name('donations');

Route::get('/disbursements', function () {
    return view('disbursements-dashboard');
})->name('disbursements');

Route::get('/donation-entry', function () {
    return view('donation-entry');
})->name('donation-entry');

// Alias for typo support as requested
Route::get('/disburements', function () {
    return view('disbursements-dashboard');
});

Route::get('/disbursement-entry', function () {
    return view('disbursement-entry');
})->name('disbursement-entry');

Route::get('/repayment-entry', function () {
    return view('repayment-entry');
})->name('repayment-entry');

