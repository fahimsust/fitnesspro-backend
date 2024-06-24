<?php

use App\Api\Admin\Orders\Controllers\OrderProductController;
use App\Api\Admin\Products\Controllers\ArchiveProductController;
use App\Api\Admin\Products\Controllers\ArchiveProductsController;
use App\Api\Admin\Products\Controllers\DefaultInventoryController;
use App\Api\Admin\Products\Controllers\DistributorsInventoryController;
use App\Api\Admin\Products\Controllers\ProductAccessoryController;
use App\Api\Admin\Products\Controllers\ProductAccessoryFieldController;
use App\Api\Admin\Products\Controllers\ProductAddToCartSettingsController;
use App\Api\Admin\Products\Controllers\ProductAttributeController;
use App\Api\Admin\Products\Controllers\ProductAvailabilitiesController;
use App\Api\Admin\Products\Controllers\ProductCategoryImageController;
use App\Api\Admin\Products\Controllers\ProductContentController;
use App\Api\Admin\Products\Controllers\ProductController;
use App\Api\Admin\Products\Controllers\ProductCustomsInfoController;
use App\Api\Admin\Products\Controllers\ProductDetailsController;
use App\Api\Admin\Products\Controllers\ProductDetailsImageController;
use App\Api\Admin\Products\Controllers\ProductFormController;
use App\Api\Admin\Products\Controllers\ProductFulfillmentRuleController;
use App\Api\Admin\Products\Controllers\ProductImageController;
use App\Api\Admin\Products\Controllers\ProductImagesController;
use App\Api\Admin\Products\Controllers\ProductMetaDataController;
use App\Api\Admin\Products\Controllers\ProductPricingController;
use App\Api\Admin\Products\Controllers\ProductPricingsController;
use App\Api\Admin\Products\Controllers\ProductSiteOrderingRuleController;
use App\Api\Admin\Products\Controllers\ProductSitePricingRuleController;
use App\Api\Admin\Products\Controllers\ProductSiteSettingModuleController;
use App\Api\Admin\Products\Controllers\ProductSiteSettingModuleValueController;
use App\Api\Admin\Products\Controllers\ProductSiteSettingsController;
use App\Api\Admin\Products\Controllers\ProductSiteStatusController;
use App\Api\Admin\Products\Controllers\ProductStatusController;
use App\Api\Admin\Products\Controllers\ProductTranslationContentController;
use App\Api\Admin\Products\Controllers\ProductTranslationController;
use App\Api\Admin\Products\Controllers\ProductTranslationCustomInfoController;
use App\Api\Admin\Products\Controllers\ProductTranslationMetaDataController;
use App\Api\Admin\Products\Controllers\ProductVariantBulkUpdateController;
use App\Api\Admin\Products\Controllers\ProductVariantController;
use App\Api\Admin\Products\Controllers\ProductVariantSummaryController;
use App\Api\Admin\Products\Controllers\ProductWaitingVariantController;
use App\Api\Admin\Products\Controllers\RelatedProductController;
use App\Api\Admin\Products\Controllers\UpdateProductDetailsTypeController;
use App\Api\Admin\ProductSettingsTemplates\Controllers\ProductSettingsTemplateController;
use App\Api\Admin\ProductSettingsTemplates\Controllers\ProductSettingsTemplateModuleController;
use App\Api\Admin\ProductSettingsTemplates\Controllers\ProductSettingTemplateModuleValueController;
use App\Api\Admin\SearchForms\Controllers\SearchFormController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->as('products.')->group(function () {
    Route::controller(ArchiveProductsController::class)
        ->group(function () {
            Route::post('archive', 'destroy')->name('archive');
            Route::post('restore', 'store')->name('restore');
        });
});

Route::prefix('product-module')->as('product-module.')->group(function () {
    Route::get('sections', ProductSiteSettingModuleController::class)->name('sections');
});

Route::apiResource('product-module-value', ProductSiteSettingModuleValueController::class)
    ->only('store', 'index');

Route::apiResource('product-attribute', ProductAttributeController::class)
    ->only('store', 'index', 'destroy');


Route::controller(ProductVariantBulkUpdateController::class)
    ->prefix('variant-bulk-update')->as('variant-bulk-update.')
    ->group(
        function () {
            Route::post('/status', 'status')->name('status');
            Route::post('/out-of-stock', 'outOfStock')->name('out-of-stock');
            Route::post('/image', 'image')->name('image');
            Route::post('/default-distributor', 'defaultDistributor')->name('default-distributor');
            Route::post('/distributor-stock-quantity', 'distributorStockQuantity')->name('distributor-stock-quantity');
        }
    );


Route::apiResource('product', ProductController::class);
Route::apiResource('search-form', SearchFormController::class);
Route::get('product-availabilities', ProductAvailabilitiesController::class)->name('product-availabilities');
Route::get('product-images', ProductImagesController::class)->name('product-images');

Route::apiResource('product-settings-template', ProductSettingsTemplateController::class);
Route::prefix('product-settings-template-module')->as('product-settings-template-module.')->group(function () {
    Route::get('sections', ProductSettingsTemplateModuleController::class)->name('sections');
});
Route::apiResource('product-settings-template-module-value', ProductSettingTemplateModuleValueController::class)
    ->only('store', 'index');

Route::prefix('product/{product}')->as('product.')->group(function () {
    Route::controller(ArchiveProductController::class)->group(function () {
        Route::post('archive', 'destroy')->name('archive');
        Route::post('restore', 'store')->name('restore');
    });
    Route::apiResource('translation', ProductTranslationController::class)->only(['show','update']);
    Route::apiResource('meta-translation', ProductTranslationMetaDataController::class)->only(['update']);
    Route::apiResource('content-translation', ProductTranslationContentController::class)->only(['update']);
    Route::apiResource('customs-translation', ProductTranslationCustomInfoController::class)->only(['update']);

    Route::get('order-product', OrderProductController::class)->name('order-product');

    Route::get('product-variant-summary', ProductVariantSummaryController::class)->name('variant-summary');
    Route::apiResource('product-variant', ProductVariantController::class)->only(['index', 'destroy']);
    Route::apiResource('product-awaiting-variant', ProductWaitingVariantController::class)->only(['index', 'store']);

    Route::apiResource('pricing', ProductPricingController::class)
        ->only(['index', 'store','show']);

    Route::get('pricings', ProductPricingsController::class)->name('pricings');
    Route::post('update-type', UpdateProductDetailsTypeController::class)->name('update-type');

    Route::apiResource('site-setting', ProductSiteSettingsController::class)->only(['index', 'store']);;

    Route::post('details-image', ProductDetailsImageController::class)
        ->name('details-image');

    Route::post('category-image', ProductCategoryImageController::class)
        ->name('category-image');

    Route::post('status', ProductStatusController::class)->name('status');

    Route::post('site-status', ProductSiteStatusController::class)
        ->name('site-status');

    Route::post('details', ProductDetailsController::class)->name('details');
    Route::post('content', ProductContentController::class)->name('content');

    Route::post('fulfillment-rule', ProductFulfillmentRuleController::class)
        ->name('fulfillment-rule');

    Route::post('pricing-rule', ProductSitePricingRuleController::class)
        ->name('pricing-rule');

    Route::post('ordering-rule', ProductSiteOrderingRuleController::class)
        ->name('ordering-rule');

    Route::apiResource('accessory', ProductAccessoryController::class)
        ->only(['store', 'destroy', 'index']);

    Route::apiResource('accessory-field', ProductAccessoryFieldController::class)
        ->only(['store', 'destroy', 'index']);

    Route::apiResource('related', RelatedProductController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource('image', ProductImageController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::apiResource('meta-data', ProductMetaDataController::class)
        ->only(['index', 'store']);

    Route::apiResource('form', ProductFormController::class)
        ->only(['index', 'store', 'destroy']);

    Route::apiResource('default-inventory', DefaultInventoryController::class)
        ->only(['store']);

    Route::apiResource('distributor-inventory', DistributorsInventoryController::class)
        ->only(['index', 'store']);

    Route::apiResource('add-to-cart-settings', ProductAddToCartSettingsController::class)
        ->only(['index', 'store']);

    Route::apiResource('customs-info', ProductCustomsInfoController::class)
        ->only(['index', 'store']);
});
