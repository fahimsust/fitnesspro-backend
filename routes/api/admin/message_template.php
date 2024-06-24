<?php

use App\Api\Admin\MessageTemplates\Controllers\MessageTemplateCategoryController;
use App\Api\Admin\MessageTemplates\Controllers\MessageTemplateController;
use App\Api\Admin\MessageTemplates\Controllers\MessageTemplatesController;
use App\Api\Admin\MessageTemplates\Controllers\MessageTemplateTranslationController;
use Illuminate\Support\Facades\Route;


Route::prefix('message-template/{messageTemplate}')->as('message-template.')->group(function () {
    Route::apiResource('translation', MessageTemplateTranslationController::class)->only(['show', 'update']);
});
Route::apiResource('message-template', MessageTemplateController::class);
Route::apiResource('message-template-category', MessageTemplateCategoryController::class);
Route::prefix('message-templates')->as('message-templates.')->group(function () {
    Route::get('', MessageTemplatesController::class)->name('list');
});
