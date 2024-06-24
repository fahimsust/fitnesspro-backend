<?php

use App\Api\Orders\Controllers\Checkout\AccountController;
use App\Api\Orders\Controllers\Checkout\BillingAddressController;
use App\Api\Orders\Controllers\Checkout\CommentsController;
use App\Api\Orders\Controllers\Checkout\OrderController;
use App\Api\Orders\Controllers\Checkout\PayCompleteController;
use App\Api\Orders\Controllers\Checkout\PaymentMethodController;
use App\Api\Orders\Controllers\Checkout\RecoveryController;
use App\Api\Orders\Controllers\Checkout\ShipmentsController;
use App\Api\Orders\Controllers\Checkout\ShippingAddressController;
use App\Api\Orders\Controllers\Checkout\StartController;
use Illuminate\Support\Facades\Route;

Route::prefix('checkout')
    ->as('checkout.')
    ->group(function () {
        Route::post('start', StartController::class)
            ->name('start');

        Route::prefix('{checkout_uuid}')->group(function () {
            Route::post('account', AccountController::class)
                ->name('account.update');

            Route::post(
                'shipping-address',
                ShippingAddressController::class
            )
                ->name('shipping-address');

            Route::post(
                'billing-address',
                BillingAddressController::class
            )
                ->name('billing-address');

            Route::prefix('shipments')
                ->name('shipments.')
                ->group(function () {
                    Route::get(
                        '/',
                        [ShipmentsController::class, 'index']
                    )->name('rate');

                    Route::name('methods.')
                        ->prefix('methods')
                        ->group(function () {
                            Route::post(
                                '/',
                                [ShipmentsController::class, 'store']
                            )->name('save');
                        });

                    Route::put(
                        '{shipment_id}/shipping-method',
                        [ShipmentsController::class, 'update']
                    )->name('shipment.method.update');
                });

            Route::post(
                'payment-method',
                PaymentMethodController::class
            )->name('payment-method');

            Route::post(
                'comments',
                CommentsController::class
            )
                ->name('comments');

            Route::post(
                'recover',
                [RecoveryController::class, 'show']
            )
                ->name('show');

            Route::post(
                'pay',
                [PayCompleteController::class, 'store']
            )->name('pay');

            Route::put(
                'complete',
                [PayCompleteController::class, 'update']
            )->name('complete');

            Route::post('order', OrderController::class)
                ->name('order');
        });
    });
