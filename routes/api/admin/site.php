<?php

use App\Api\Admin\Sites\Controllers\AllowedAccountTypesController;
use App\Api\Admin\Sites\Controllers\AllowOrderingOfController;
use App\Api\Admin\Sites\Controllers\CheckoutPaymentMethodController;
use App\Api\Admin\Sites\Controllers\DefaultAccountTypeController;
use App\Api\Admin\Sites\Controllers\OfflineSettingsController;
use App\Api\Admin\Sites\Controllers\OnlineOfflineController;
use App\Api\Admin\Sites\Controllers\SettingsForSiteController;
use App\Api\Admin\Sites\Controllers\SiteCategoryController;
use App\Api\Admin\Sites\Controllers\SiteCategoryFilterController;
use App\Api\Admin\Sites\Controllers\SiteController;
use App\Api\Admin\Sites\Controllers\SiteCurrencyController;
use App\Api\Admin\Sites\Controllers\SiteInventoryRuleController;
use App\Api\Admin\Sites\Controllers\SiteLanguageController;
use App\Api\Admin\Sites\Controllers\SiteMessageTemplateController;
use App\Api\Admin\Sites\Controllers\SiteMetaDataController;
use App\Api\Admin\Sites\Controllers\SiteOfflineMessageTranslationController;
use App\Api\Admin\Sites\Controllers\SiteSettingModuleController;
use App\Api\Admin\Sites\Controllers\SiteSettingModuleValueController;
use App\Api\Admin\Sites\Controllers\SiteTranslationController;
use App\Api\Admin\Sites\Controllers\SubscriptionPaymentMethodController;
use App\Api\Admin\Sites\Controllers\UpdateSectionLayoutController;
use App\Api\Admin\Sites\Controllers\UpdateSectionModuleTemplateController;
use Illuminate\Support\Facades\Route;


Route::prefix('site')->as('site.')->group(function () {
    Route::resource('', SiteController::class)
        ->only(['index', 'store']);

    Route::prefix('module')->as('module.')->group(function () {
        Route::get('sections', SiteSettingModuleController::class)->name('sections');
    });
    Route::apiResource('module-value', SiteSettingModuleValueController::class)
        ->only('store', 'index');

    Route::prefix('{site}')->group(function () {
        Route::controller(SiteController::class)->group(function () {
            Route::put('/', 'update')->name('update');
            Route::get('/', 'show')->name('show');
            //                    Route::delete('/', 'destroy')->name('delete');
        });
        Route::apiResource('translation', SiteTranslationController::class)->only(['show','update']);
        Route::apiResource('translation-offline', SiteOfflineMessageTranslationController::class)->only(['update']);

        Route::controller(OnlineOfflineController::class)->group(function () {
            Route::delete('offline', 'destroy')->name('offline');
            Route::post('online', 'store')->name('online');
        });

        Route::apiResource('category', SiteCategoryController::class)
            ->only(['index', 'store', 'destroy']);

        Route::apiResource('language', SiteLanguageController::class);
        Route::apiResource('currency', SiteCurrencyController::class);

        Route::apiResource('inventory-rule', SiteInventoryRuleController::class)
            ->only(['index', 'store', 'destroy']);

        Route::prefix('payment-options')->as('payment-options.')->group(function () {
            Route::prefix('subscription')->as('subscription.')
                ->controller(SubscriptionPaymentMethodController::class)->group(function () {
                    Route::post('activate', 'store')->name('activate');
                    Route::delete('deactivate', 'destroy')->name('deactivate');
                    Route::get('', 'index')->name('get');
                });

            Route::prefix('checkout')->as('checkout.')
                ->controller(CheckoutPaymentMethodController::class)->group(function () {
                    Route::post('activate', 'store')->name('activate');
                    Route::put('update', 'update')->name('update');
                    Route::delete('deactivate', 'destroy')->name('deactivate');
                    Route::get('get', 'index')->name('get');
                });
        });

        Route::post('update-meta', SiteMetaDataController::class)
            ->name('update-meta');

        Route::post('default-account-type', DefaultAccountTypeController::class)
            ->name('default-account-type');

        Route::resource('offline-settings', OfflineSettingsController::class)
            ->only(['index', 'store']);

        Route::resource('settings', SettingsForSiteController::class)
            ->only(['index', 'store']);

        Route::resource('default-layout', UpdateSectionLayoutController::class)
            ->only(['store']);

        Route::resource('module-template', UpdateSectionModuleTemplateController::class)
            ->only(['store']);

        Route::resource('allow-ordering', AllowOrderingOfController::class)
            ->only(['index', 'store']);

        Route::resource('message-template', SiteMessageTemplateController::class)
            ->only(['index', 'store']);

        Route::resource('category-filter', SiteCategoryFilterController::class)
            ->only(['store']);
    });
});
