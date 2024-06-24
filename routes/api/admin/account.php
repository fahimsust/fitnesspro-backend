<?php

use App\Api\Admin\Accounts\Controllers\AccountAddressController;
use App\Api\Admin\Accounts\Controllers\AccountAdminLoginController;
use App\Api\Admin\Accounts\Controllers\AccountCertificationController;
use App\Api\Admin\Accounts\Controllers\AccountController;
use App\Api\Admin\Accounts\Controllers\AccountEmailController;
use App\Api\Admin\Accounts\Controllers\AccountFileController;
use App\Api\Admin\Accounts\Controllers\AccountMembershipController;
use App\Api\Admin\Accounts\Controllers\AccountOrderController;
use App\Api\Admin\Accounts\Controllers\AccountPhotoController;
use App\Api\Admin\Accounts\Controllers\AccountSpecialtyController;
use App\Api\Admin\Accounts\Controllers\AccountStatusController;
use App\Api\Admin\Accounts\Controllers\AdminEmailAccountController;
use Illuminate\Support\Facades\Route;

Route::apiResource('accounts', AccountController::class)->only(['index', 'update', 'show']);
Route::apiResource('account-status', AccountStatusController::class);
Route::apiResource('account-membership', AccountMembershipController::class);
Route::apiResource('account-address', AccountAddressController::class);
Route::apiResource('account-specialty', AccountSpecialtyController::class);
Route::apiResource('account-order', AccountOrderController::class)->only(['index']);
Route::apiResource('account-photo', AccountPhotoController::class)->only(['index', 'update', 'destroy']);
Route::apiResource('account-certification', AccountCertificationController::class);
Route::apiResource('account-file', AccountFileController::class)->only(['index', 'store', 'destroy']);
Route::middleware('web')->group(function () {
    Route::apiResource('account-login', AccountAdminLoginController::class)->only(['store']);
});

Route::prefix('contact-customer')->as('contact-customer.')->group(function () {
    Route::post('', AdminEmailAccountController::class)->name('store');
});
Route::apiResource('contact-customer', AccountEmailController::class)->only(['index']);
