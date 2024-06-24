<?php

use App\Api\Support\Controllers\CountriesController;
use App\Api\Support\Controllers\CurrencyController;
use App\Api\Support\Controllers\ImageController;
use App\Api\Support\Controllers\StatesController;
use App\Api\Support\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::prefix('countries')->as('countries.')->group(function () {
    Route::get('/', CountriesController::class)->name('list');
});
Route::prefix('currency/{site_id}')->as('currency.')->group(function () {
    Route::get('base', CurrencyController::class)->name('base');
});
Route::prefix('states/{country_id}')->as('states.')->group(function () {
    Route::get('/', StatesController::class)->name('list');
});
Route::apiResource('image', ImageController::class)->only('index', 'store');
Route::apiResource('upload-file', UploadController::class)->only('store', 'destroy');
