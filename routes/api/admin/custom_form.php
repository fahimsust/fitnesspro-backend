<?php

use App\Api\Admin\CustomForms\Controllers\CustomFieldController;
use App\Api\Admin\CustomForms\Controllers\CustomFormController;
use App\Api\Admin\CustomForms\Controllers\CustomFormsController;
use App\Api\Admin\CustomForms\Controllers\FormSectionController;
use App\Api\Admin\CustomForms\Controllers\FormSectionFieldController;
use App\Api\Admin\CustomForms\Controllers\CustomFieldOptionController;
use App\Api\Admin\CustomForms\Controllers\CustomFormAllController;
use App\Api\Admin\CustomForms\Controllers\FieldTranslationController;
use App\Api\Admin\CustomForms\Controllers\FormTranslationController;
use App\Api\Admin\CustomForms\Controllers\SectionTranslationController;
use Illuminate\Support\Facades\Route;

Route::prefix('custom-forms')->as('custom-forms.')->group(function () {
    Route::get('', CustomFormsController::class)->name('list');
});
Route::apiResource('custom-form', CustomFormController::class);
Route::apiResource('custom-form-list', CustomFormAllController::class)->only('index');
Route::prefix('custom-form/{custom_form}')->as('custom-form.')->group(function () {
        Route::apiResource('translation', FormTranslationController::class)->only(['show','update']);
});

Route::apiResource('custom-form-section', FormSectionController::class)
        ->only(['index', 'store','update', 'destroy']);
Route::prefix('custom-form-section/{form_section}')->as('custom-form-section.')->group(function () {
        Route::apiResource('translation', SectionTranslationController::class)->only(['show','update']);
});
Route::prefix('custom-field/{custom_field}')->as('custom-field.')->group(function () {
        Route::apiResource('translation', FieldTranslationController::class)->only(['show','update']);
});

Route::apiResource('custom-form-field', FormSectionFieldController::class)
        ->only(['store','update', 'destroy']);

Route::apiResource('custom-field', CustomFieldController::class)
        ->only(['index', 'store','update','show']);

Route::apiResource('custom-field-option', CustomFieldOptionController::class)
        ->only(['index','store','update', 'destroy']);


