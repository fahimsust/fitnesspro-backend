<?php

use App\Api\Admin\Currency\Controllers\CurrencyController;
use App\Api\Admin\DisplayTemplates\Controllers\CategoryDisplayTemplateController;
use App\Api\Admin\DisplayTemplates\Controllers\DetailDisplayTemplateController;
use App\Api\Admin\Elements\Controllers\ElementController;
use App\Api\Admin\Elements\Controllers\ElementStatusController;
use App\Api\Admin\ModuleTemplates\Controllers\ModuleTemplateController;
use App\Api\Admin\Pages\Controllers\PageController;
use App\Api\Admin\Pages\Controllers\PageMetaDataController;
use App\Api\Admin\Pages\Controllers\PageStatusController;
use App\Api\Admin\ProductSettingsTemplates\Controllers\ProductSettingsTemplateController;
use App\Api\Admin\DisplayTemplates\Controllers\DisplayTemplateController;
use App\Api\Admin\DisplayTemplates\Controllers\DisplayTemplateTypeController;
use App\Api\Admin\DisplayTemplates\Controllers\ThumbnailDisplayTemplateController;
use App\Api\Admin\DisplayTemplates\Controllers\ZoomDisplayTemplateController;
use App\Api\Admin\Elements\Controllers\ElementTranslationController;
use App\Api\Admin\InventoryRules\Controllers\InventoryRuleController;
use App\Api\Admin\Languages\Controllers\LanguageController;
use App\Api\Admin\Layouts\Controllers\LayoutController;
use App\Api\Admin\Layouts\Controllers\LayoutSectionController;
use App\Api\Admin\Modules\Controllers\ModuleController;
use App\Api\Admin\ModuleTemplates\Controllers\ModuleTemplateModuleController;
use App\Api\Admin\ModuleTemplates\Controllers\ModuleTemplatesController;
use App\Api\Admin\ModuleTemplates\Controllers\ModuleTemplateSectionController;
use App\Api\Admin\Pages\Controllers\PageTranslationController;
use App\Api\Admin\Pages\Controllers\PageTranslationMetaDataController;
use Illuminate\Support\Facades\Route;

Route::prefix('page/{page}')->as('page.')->group(function () {
    Route::post('status', PageStatusController::class)->name('status');
    Route::post('meta-data', PageMetaDataController::class)->name('meta-data');
    Route::apiResource('translation', PageTranslationController::class)->only(['show', 'update']);
    Route::apiResource('meta-translation', PageTranslationMetaDataController::class)->only(['update']);
});

Route::apiResource('page', PageController::class);

Route::prefix('element/{element}')->as('element.')->group(function () {
    Route::post('status', ElementStatusController::class)->name('status');
    Route::apiResource('translation', ElementTranslationController::class)->only(['show', 'update']);
});

Route::apiResource('element', ElementController::class);
Route::apiResource('display-template', DisplayTemplateController::class);
Route::apiResource('display-template-type', DisplayTemplateTypeController::class)->only(['index']);
Route::apiResource('module-template', ModuleTemplateController::class);
Route::prefix('module-templates')->as('module-templates.')->group(function () {
    Route::get('', ModuleTemplatesController::class)->name('list');
});
Route::apiResource('module-template-section', ModuleTemplateSectionController::class);
Route::apiResource('module-template-module', ModuleTemplateModuleController::class);
Route::apiResource('module', ModuleController::class);
Route::apiResource('layout', LayoutController::class);
Route::apiResource('display-template-detail', DetailDisplayTemplateController::class);
Route::apiResource('display-template-thumbnail', ThumbnailDisplayTemplateController::class);
Route::apiResource('display-template-category', CategoryDisplayTemplateController::class);
Route::apiResource('display-template-zoom', ZoomDisplayTemplateController::class);
Route::apiResource('languages', LanguageController::class)->only(['index', 'show']);
Route::apiResource('currency', CurrencyController::class)->only(['index', 'show']);
Route::apiResource('inventory-rule', InventoryRuleController::class)->only(['index']);

Route::apiResource('layout-section', LayoutSectionController::class)->only(['index']);
