<?php

use App\Api\Admin\Categories\Controllers\CategoriesController;
use App\Api\Admin\Categories\Controllers\CategoryBrandsController;
use App\Api\Admin\Categories\Controllers\CategoryController;
use App\Api\Admin\Categories\Controllers\CategoryFeatureProductController;
use App\Api\Admin\Categories\Controllers\CategoryImageController;
use App\Api\Admin\Categories\Controllers\CategoryMetaDataController;
use App\Api\Admin\Categories\Controllers\CategoryParentController;
use App\Api\Admin\Categories\Controllers\CategoryProductTypesController;
use App\Api\Admin\Categories\Controllers\CategoryStatusController;
use App\Api\Admin\Categories\Controllers\CategoryTranslationController;
use App\Api\Admin\Categories\Controllers\CategoryTranslationMetaDataController;
use App\Api\Admin\Categories\Controllers\Products\CategoryHideProductController;
use App\Api\Admin\Categories\Controllers\Products\CategoryShowProductController;
use App\Api\Admin\Categories\Controllers\Rules\CategoryRuleConditionController;
use App\Api\Admin\Categories\Controllers\Rules\CategoryRuleController;
use App\Api\Admin\Categories\Controllers\Settings\CategoryFilterSettingsController;
use App\Api\Admin\Categories\Controllers\Settings\CategoryMenuSettingsController;
use App\Api\Admin\Categories\Controllers\Settings\CategorySettingsController;
use App\Api\Admin\Categories\Controllers\Settings\CategorySiteSettingModuleController;
use App\Api\Admin\Categories\Controllers\Settings\CategorySiteSettingModuleValueController;
use App\Api\Admin\Categories\Controllers\Settings\CategorySiteSettingsController;
use App\Api\Admin\CategorySettingsTemplates\Controllers\CategorySettingsTemplateController;
use App\Api\Admin\CategorySettingsTemplates\Controllers\CategorySettingsTemplateModuleController;
use App\Api\Admin\CategorySettingsTemplates\Controllers\CategorySettingTemplateModuleValueController;
use Illuminate\Support\Facades\Route;

Route::get('categories', CategoriesController::class)
    ->name('categories.list');

Route::prefix('category-module')->as('category-module.')->group(function () {
    Route::get('sections', CategorySiteSettingModuleController::class)->name('sections');
});

Route::apiResource('category-module-value', CategorySiteSettingModuleValueController::class)
    ->only('store', 'index');

Route::apiResource('category', CategoryController::class);
Route::apiResource('category-settings-template', CategorySettingsTemplateController::class);
Route::prefix('category-settings-template-module')->as('category-settings-template-module.')->group(function () {
    Route::get('sections', CategorySettingsTemplateModuleController::class)->name('sections');
});
Route::apiResource('category-settings-template-module-value', CategorySettingTemplateModuleValueController::class)
    ->only('store', 'index');


Route::prefix('parent')->as('parent.')
        ->group(function () {
            Route::apiResource('category', CategoryParentController::class)->only('index','update');
        });


Route::prefix('category/{category}')->as('category.')->group(function () {
    Route::prefix('product')->as('product.')->group(function () {
        Route::apiResource('show', CategoryShowProductController::class)
            ->only(['index', 'store', 'destroy','update']);

        Route::apiResource('hide', CategoryHideProductController::class)
            ->only(['index', 'store', 'destroy']);

        Route::apiResource('type', CategoryProductTypesController::class)
            ->only(['index', 'store', 'destroy']);

        Route::apiResource('featured', CategoryFeatureProductController::class)
            ->only(['index', 'store', 'destroy','update']);
    });
    Route::apiResource('translation', CategoryTranslationController::class)->only(['show','update']);
    Route::apiResource('meta-translation', CategoryTranslationMetaDataController::class)->only(['update']);

    Route::apiResource('brand', CategoryBrandsController::class)
        ->only(['index', 'store', 'destroy']);

    Route::prefix('settings-template')->as('settings-template.')
        ->group(function () {
            Route::apiResource('site', CategorySiteSettingsController::class)
                ->only(['store','index']);
            Route::apiResource('', CategorySettingsController::class)
                ->only(['store','index']);
        });



    Route::apiResource('filter', CategoryFilterSettingsController::class)
        ->only(['index', 'store']);

    Route::apiResource('menu-setting', CategoryMenuSettingsController::class)
        ->only(['index', 'store']);

    Route::apiResource('meta-data', CategoryMetaDataController::class)
        ->only(['index', 'store']);

    Route::apiResource('image', CategoryImageController::class)
        ->only(['store']);

    Route::apiResource('status', CategoryStatusController::class)
        ->only(['store']);

    Route::apiResource('rule', CategoryRuleController::class);
});
Route::prefix('category-rule/{category_rule}')->as('category-rule.')->group(function () {
    Route::apiResource('condition', CategoryRuleConditionController::class);
});
