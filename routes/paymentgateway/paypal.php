<?php

use App\Http\Controllers\gateway\PaypayController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::prefix('paypal')->withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::post('callback', [PaypayController::class, 'callback']);
    Route::post('failed', [PaypayController::class, 'failed']);
})->name('paypal.callback');
