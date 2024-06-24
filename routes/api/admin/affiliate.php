<?php

use App\Api\Admin\Affiliates\Controllers\AffiliateAddressController;
use App\Api\Admin\Affiliates\Controllers\AffiliateController;
use App\Api\Admin\Affiliates\Controllers\AffiliateLevelController;
use App\Api\Admin\Affiliates\Controllers\AffiliateRestoreController;
use App\Api\Admin\Referrals\Controllers\ReferralController;
use App\Api\Admin\Referrals\Controllers\ReferralsController;
use App\Api\Admin\Referrals\Controllers\ReferralsStatusesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('affiliate', AffiliateController::class);
Route::prefix('affiliate-archive/{affiliate}')->as('affiliate-archive.')->group(function () {
    Route::put('/', AffiliateRestoreController::class)->name('restore');
});
Route::prefix('affiliate-address/{affiliate}')->as('affiliate-address.')->group(function () {
    Route::put('/', AffiliateAddressController::class)->name('update');
});
Route::apiResource('affiliate-level', AffiliateLevelController::class)->only(['index']);
Route::prefix('referrals/{affiliate_id}')->as('referrals.')->group(function () {
    Route::get('/', ReferralsController::class)->name('list');
});
Route::apiResource('referral', ReferralController::class)->only(['index','update']);
Route::prefix('referrals-statuses')->as('referrals-statuses.')->group(function () {
    Route::get('/', ReferralsStatusesController::class)->name('list');
});
