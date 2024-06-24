<?php

use App\Api\Site\Reviews\Controllers\AttributeReviewsController;
use App\Api\Site\Reviews\Controllers\ProductReviewsController;
use App\Api\Site\Reviews\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;

Route::prefix('reviews')->as('reviews.')->group(function () {
    Route::controller(ProductReviewsController::class)->as('product.')->group(function () {
        Route::get('product/{product}', 'list')->name('list');
        Route::post('product/{product}', 'store')->name('store');
    });

    Route::controller(AttributeReviewsController::class)->as('attribute.')->group(function () {
        Route::get('attribute/{attribute_option}', 'list')->name('list');
        Route::post('attribute/{attribute_option}', 'store')->name('store');
    });

    Route::post('', ReviewsController::class)->name('list');
});
