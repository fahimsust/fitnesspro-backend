<?php

use App\Api\Admin\Attributes\Controllers\AttributeController;
use App\Api\Admin\Attributes\Controllers\AttributeOptionController;
use App\Api\Admin\Attributes\Controllers\AttributeOptionsController;
use App\Api\Admin\Attributes\Controllers\AttributeOptionSearchController;
use App\Api\Admin\Attributes\Controllers\AttributeOptionTranslationController;
use App\Api\Admin\Attributes\Controllers\AttributesController;
use App\Api\Admin\Attributes\Controllers\AttributeSetController;
use App\Api\Admin\Attributes\Controllers\AttributeSetsController;
use App\Api\Admin\Attributes\Controllers\AttributeSetTranslationController;
use App\Api\Admin\Attributes\Controllers\AttributeTranslationController;
use App\Api\Admin\Attributes\Controllers\AttributeTypesController;
use Illuminate\Support\Facades\Route;

Route::prefix('attributes')->as('attributes.')->group(function () {
    Route::get('', AttributesController::class)->name('list');
});
Route::prefix('attribute-options')->as('attribute-options.')->group(function () {
    Route::get('', AttributeOptionsController::class)->name('list');
});
Route::prefix('attribute-sets')->as('attribute-sets.')->group(function () {
    Route::get('', AttributeSetsController::class)->name('list');
});
Route::prefix('attribute/{attribute}')->as('attribute.')->group(function () {
    Route::apiResource('translation', AttributeTranslationController::class)->only(['show', 'update']);
});
Route::prefix('attribute-set/{attribute_set}')->as('attribute-set.')->group(function () {
    Route::apiResource('translation', AttributeSetTranslationController::class)->only(['show', 'update']);
});
Route::prefix('attribute-option/{attribute_option}')->as('attribute-option.')->group(function () {
    Route::apiResource('translation', AttributeOptionTranslationController::class)->only(['show', 'update']);
});
Route::apiResource('attribute-types', AttributeTypesController::class)->only('index');
Route::apiResource('attribute-set', AttributeSetController::class);
Route::apiResource('attribute', AttributeController::class);
Route::apiResource('attribute-option', AttributeOptionController::class);
Route::get('attribute-option-search', AttributeOptionSearchController::class)->name('attribute-option-search');
