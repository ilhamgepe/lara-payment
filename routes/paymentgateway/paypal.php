<?php

use App\Http\Controllers\gateway\PaypalController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::prefix('paypal')->withoutMiddleware([VerifyCsrfToken::class])->group(function () {
    Route::get('createOrder', [PaypalController::class, 'createOrder'])->name('createOrder');
    Route::get('callback', [PaypalController::class, 'callback']);
    Route::get('failed', [PaypalController::class, 'failed']);
});
