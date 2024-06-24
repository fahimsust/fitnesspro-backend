<?php

use App\Api\Admin\Faqs\Controllers\FaqCategoriesController;
use App\Api\Admin\Faqs\Controllers\FaqCategoryController;
use App\Api\Admin\Faqs\Controllers\FaqCategoryListController;
use App\Api\Admin\Faqs\Controllers\FaqCategoryStatusController;
use App\Api\Admin\Faqs\Controllers\FaqCategoryTranslationController;
use App\Api\Admin\Faqs\Controllers\FaqController;
use App\Api\Admin\Faqs\Controllers\FaqStatusController;
use App\Api\Admin\Faqs\Controllers\FaqTranslationController;
use Illuminate\Support\Facades\Route;

Route::prefix('faq/{faq}')->as('faq.')->group(function () {
    Route::apiResource('category', FaqCategoriesController::class)
        ->only(['store', 'destroy', 'index']);
    Route::apiResource('translation', FaqTranslationController::class)->only(['show', 'update']);
    Route::post('status', FaqStatusController::class)->name('status');
});
Route::prefix('faq-category/{faq_category}')->as('faq-category.')->group(function () {
    Route::apiResource('translation', FaqCategoryTranslationController::class)->only(['show', 'update']);
    Route::post('status', FaqCategoryStatusController::class)->name('status');
});

Route::get('faq-category-list', FaqCategoryListController::class)->name('faq-category-list');
Route::apiResource('faq', FaqController::class);
Route::apiResource('faq-category', FaqCategoryController::class);

