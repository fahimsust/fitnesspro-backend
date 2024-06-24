<?php

use App\Api\Admin\AccessoryField\Controllers\AccessoryFieldsController;
use Illuminate\Support\Facades\Route;

Route::prefix('accessory-fields')->as('accessory-fields.')->group(function () {
    Route::get('', AccessoryFieldsController::class)->name('list');
});
