<?php

use App\Api\Admin\Products\Types\Controllers\ProductTypeAttributesController;
use App\Api\Admin\Products\Types\Controllers\ProductTypeAttributeSetController;
use App\Api\Admin\Products\Types\Controllers\ProductTypeController;
use App\Api\Admin\Products\Types\Controllers\ProductTypesController;
use App\Api\Admin\Products\Types\Controllers\ProductTypeTaxRuleController;
use Illuminate\Support\Facades\Route;

Route::prefix('product-types')->as('product-types.')->group(function () {
    Route::get('', ProductTypesController::class)->name('list');
});
Route::apiResource('product-type', ProductTypeController::class);

Route::prefix('product-type/{productType}')->as('product-type.')->group(function () {
    Route::apiResource('attribute-set', ProductTypeAttributeSetController::class)
        ->only(['index', 'store', 'destroy']);

    Route::get('attributes', ProductTypeAttributesController::class)->name('attributes');

    Route::apiResource('tax-rule', ProductTypeTaxRuleController::class)
        ->only(['index','store', 'destroy']);
});
