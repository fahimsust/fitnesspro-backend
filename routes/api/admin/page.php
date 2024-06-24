<?php

use App\Api\Admin\Pages\Controllers\PageController;
use App\Api\Admin\Pages\Controllers\PageMetaDataController;
use App\Api\Admin\Pages\Controllers\PageStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('page/{page}')->as('page.')->group(function () {
    Route::post('status', PageStatusController::class)->name('status');
    Route::post('meta-data', PageMetaDataController::class)->name('meta-data');
});

Route::apiResource('page', PageController::class);
