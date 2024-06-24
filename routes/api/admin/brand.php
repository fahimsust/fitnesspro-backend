<?php

use App\Api\Admin\Brands\Controllers\BrandController;
use App\Api\Admin\Brands\Controllers\BrandsController;
use Illuminate\Support\Facades\Route;

Route::prefix('brands')->as('brands.')->group(function () {
    Route::get('', BrandsController::class)->name('list');
});
Route::apiResource('brand', BrandController::class);
