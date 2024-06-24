<?php

use App\Api\Admin\AccountType\Controllers\AccountTypeController;
use App\Api\Admin\AccountType\Controllers\AccountTypesController;
use App\Api\Admin\LoyaltyProgram\Controllers\LoyaltyProgramController;
use Illuminate\Support\Facades\Route;

Route::prefix('account-types')->as('account-types.')->group(function () {
    Route::get('', AccountTypesController::class)->name('list');
});
Route::apiResource('account-type', AccountTypeController::class)->only('index', 'store', 'update');
Route::apiResource('loyalty-program', LoyaltyProgramController::class)->only('index');
