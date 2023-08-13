<?php

use App\Http\Controllers\gateway\StripeController;
use Illuminate\Support\Facades\Route;

Route::prefix('stripe')->group(function () {
    Route::post('payment', [StripeController::class, 'payment'])->name('stripe.payment');
    Route::get('success', [StripeController::class, 'success'])->name('stripe.success');
    Route::get('cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');
    Route::post('callback', [StripeController::class, 'callback'])->withoutMiddleware('web')->name('stripe.callback');
});
