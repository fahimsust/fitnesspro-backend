<?php

use App\Api\Admin\Discounts\Controllers\AdvantageOptionController;
use App\Api\Admin\Discounts\Controllers\AdvantageProductController;
use App\Api\Admin\Discounts\Controllers\AdvantageProductTypeController;
use App\Api\Admin\Discounts\Controllers\ConditionAccountTypeController;
use App\Api\Admin\Discounts\Controllers\ConditionAttributeController;
use App\Api\Admin\Discounts\Controllers\ConditionAvailabilityController;
use App\Api\Admin\Discounts\Controllers\ConditionCountryController;
use App\Api\Admin\Discounts\Controllers\ConditionDistributorController;
use App\Api\Admin\Discounts\Controllers\ConditionMemberShipController;
use App\Api\Admin\Discounts\Controllers\ConditionOptionController;
use App\Api\Admin\Discounts\Controllers\ConditionOutOfStockStatusController;
use App\Api\Admin\Discounts\Controllers\ConditionProductController;
use App\Api\Admin\Discounts\Controllers\ConditionProductTypeController;
use App\Api\Admin\Discounts\Controllers\ConditionSiteController;
use App\Api\Admin\Discounts\Controllers\DiscountAdvantageController;
use App\Api\Admin\Discounts\Controllers\DiscountConditionController;
use App\Api\Admin\Discounts\Controllers\DiscountController;
use App\Api\Admin\Discounts\Controllers\DiscountLevelActionTypeController;
use App\Api\Admin\Discounts\Controllers\DiscountLevelApplyToController;
use App\Api\Admin\Discounts\Controllers\DiscountLevelController;
use App\Api\Admin\Discounts\Controllers\DiscountLevelProductController;
use App\Api\Admin\Discounts\Controllers\DiscountLevelStatusController;
use App\Api\Admin\Discounts\Controllers\DiscountMatchRuleController;
use App\Api\Admin\Discounts\Controllers\DiscountRuleController;
use App\Api\Admin\Discounts\Controllers\DiscountStatusController;
use App\Api\Admin\ShippingMethods\Controllers\ShippingMethodsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('discount-level', DiscountLevelController::class);
Route::prefix('discount-level/{discount_level}')->as('discount-level.')->group(
    function () {
        Route::apiResource('product', DiscountLevelProductController::class)
            ->only(['index', 'store', 'destroy']);

        Route::post('status', DiscountLevelStatusController::class)->name('status');
    }
);
Route::get('discount-level-apply-to', DiscountLevelApplyToController::class)->name('discount-level-apply-to');
Route::get('discount-level-action-type', DiscountLevelActionTypeController::class)->name('discount-level-action-type');
Route::apiResource('discount', DiscountController::class);
Route::prefix('discount/{discount}')->as('discount.')->group(function () {
    Route::post('status', DiscountStatusController::class)->name('status');
});
Route::apiResource('discount-match-rule', DiscountMatchRuleController::class)->only('update');


Route::apiResource('discount-advantage', DiscountAdvantageController::class);
Route::apiResource('advantage-options', AdvantageOptionController::class)->only('index');
Route::apiResource('discount-condition-options', ConditionOptionController::class)->only('index');
Route::apiResource('advantage-product', AdvantageProductController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('advantage-product-type', AdvantageProductTypeController::class)->only(['store', 'update', 'destroy']);

Route::apiResource('discount-rule', DiscountRuleController::class);
Route::apiResource('discount-rule-condition', DiscountConditionController::class);
Route::apiResource('condition-product', ConditionProductController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('condition-product-type', ConditionProductTypeController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('condition-site', ConditionSiteController::class)->only(['store', 'destroy']);
Route::apiResource('condition-account-type', ConditionAccountTypeController::class)->only(['store', 'destroy']);
Route::apiResource('condition-attribute', ConditionAttributeController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('condition-country', ConditionCountryController::class)->only(['store', 'destroy']);
Route::apiResource('condition-distributor', ConditionDistributorController::class)->only(['store', 'destroy']);
Route::apiResource('condition-membership', ConditionMemberShipController::class)->only(['store', 'destroy']);
Route::apiResource('condition-out-of-stock-status', ConditionOutOfStockStatusController::class)->only(['store', 'update', 'destroy']);
Route::apiResource('condition-availability', ConditionAvailabilityController::class)->only(['store', 'update', 'destroy']);


Route::apiResource('shipping-methods', ShippingMethodsController::class)->only('index');
