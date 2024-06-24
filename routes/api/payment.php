<?php

use App\Api\Payments\Controllers\PaymentCancelController;
use App\Api\Payments\Controllers\PaymentConfirmController;
use Illuminate\Support\Facades\Route;

Route::prefix('payment')->as('api.payment.')->group(function () {
    Route::prefix('{order_transaction_id}')->group(function () {
        Route::post('confirm', PaymentConfirmController::class)
            ->name('confirm');

        Route::post('cancel', PaymentCancelController::class)
            ->name('cancel');
    });
});
