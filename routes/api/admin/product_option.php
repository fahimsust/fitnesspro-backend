<?php

use App\Api\Admin\ProductOptions\Controllers\CreateDateOptionValuesControllers;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionValueCustomFieldController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionTranslationController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionTypesController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionValueController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionValueImageController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionValuesController;
use App\Api\Admin\ProductOptions\Controllers\ProductOptionValueTranslationController;
use Illuminate\Support\Facades\Route;

Route::prefix('product-option-values/{product_option}')
    ->as('product-option-values.')
    ->group(function () {
        Route::get('/', ProductOptionValuesController::class)->name('list');
        Route::post('/', CreateDateOptionValuesControllers::class)->name('dates');
    });

Route::get('product-option-types', ProductOptionTypesController::class)->name('product-option-types');

Route::apiResource('product-option', ProductOptionController::class)->except(['show']);

Route::apiResource('product-option-value', ProductOptionValueController::class)
    ->except(['index']);

Route::prefix('product-option/{product_option}')
    ->as('product-option.')
    ->group(function () {
        Route::apiResource('translation', ProductOptionTranslationController::class)->only(['show', 'update']);
    });

Route::prefix('product-option-value/{product_option_value}')
    ->as('product-option-value.')
    ->group(function () {
        Route::apiResource('translation', ProductOptionValueTranslationController::class)->only(['show', 'update']);
        Route::apiResource('image', ProductOptionValueImageController::class)
            ->only(['store']);

        Route::prefix('custom-field')
            ->name('custom-field.')
            ->controller(ProductOptionValueCustomFieldController::class)
            ->group(function () {
                Route::apiResource('/', ProductOptionValueCustomFieldController::class)
                    ->only(['store', 'index']);

                Route::delete('/', 'destroy')->name('destroy');
            });
    });
