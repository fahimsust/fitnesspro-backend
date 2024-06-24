<?php

use App\Api\Products\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('category')->as('category.')->group(function () {
    Route::post('{category_slug}', CategoryController::class)
        ->name('index');
});
