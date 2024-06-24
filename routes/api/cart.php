<?php

use App\Api\Orders\Controllers\Cart\CartController;
use App\Api\Orders\Controllers\Cart\CartItemController;
use App\Api\Orders\Controllers\Cart\CartRecoveryController;
use App\Api\Orders\Controllers\Cart\Discount\CartDiscountCodeController;
use App\Api\Orders\Controllers\Cart\Discount\CartDiscountController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->as('cart.')->group(function () {
    Route::controller(CartController::class)->group(function () {
        Route::get('', 'index')->name('index');
        Route::delete('', 'destroy')->name('destroy');
    });

    Route::apiResource('item', CartItemController::class)
        ->only(['store', 'show', 'update', 'destroy']);

    Route::apiResource('discount', CartDiscountController::class);
    Route::apiResource('discount-code', CartDiscountCodeController::class)
        ->only(['index', 'store', 'destroy']);

    Route::get('recover/{hash}', CartRecoveryController::class)
        ->name('recover');
});
