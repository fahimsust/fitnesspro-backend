<?php

use App\Api\Admin\Reviews\Controllers\ReviewApprovalController;
use App\Api\Admin\Reviews\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::prefix('product-review')->as('product-review.')->group(function () {
    Route::post('{product_review}/status', ReviewApprovalController::class)
        ->name('status');
});

Route::apiResource('product-review', ReviewController::class)
    ->except(['store']);
