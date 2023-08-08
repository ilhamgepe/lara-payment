<?php

use App\Http\Controllers\gateway\PaypalController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

// paypal sendiri
// Route::prefix('paypal')->withoutMiddleware([VerifyCsrfToken::class])->group(function () {
//     Route::get('createOrder', [PaypalController::class, 'createOrder'])->name('createOrder');
//     Route::get('callback', [PaypalController::class, 'callback']);
//     Route::get('failed', [PaypalController::class, 'failed']);
// });

// paypal package
Route::prefix('paypal')->withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::get('createOrder', [PaypalController::class, 'pakcageCreateOrder'])->name('createOrder');
    Route::get('success', [PaypalController::class, 'success'])->name('paypal.successTransaction');
    Route::get('failed', [PaypalController::class, 'failed'])->name('paypal.failedTransaction');
    Route::get('notify', [PaypalController::class, 'notify'])->name('notify');
});
