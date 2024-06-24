<?php

use App\Api\Admin\OrderingRules\Controllers\OrderingConditionController;
use App\Api\Admin\OrderingRules\Controllers\OrderingConditionItemController;
use App\Api\Admin\OrderingRules\Controllers\OrderingConditionsController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleChildController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleChildrenController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleChildrensController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRulesController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleStatusController;
use App\Api\Admin\OrderingRules\Controllers\OrderingRuleTranslationController;
use Illuminate\Support\Facades\Route;

Route::prefix('ordering-rules')->as('ordering-rules.')->group(function () {
    Route::get('/', OrderingRulesController::class)->name('list');
});
Route::prefix('ordering-rule-childs/{ordering_rule}')->as('ordering-rule-childs.')->group(function () {
    Route::get('/', OrderingRuleChildrensController::class)->name('list');
});

Route::prefix('ordering-rule/{ordering_rule}')->as('ordering-rule.')->group(function () {
    Route::post('status', OrderingRuleStatusController::class)
        ->name('status');

    Route::get('children', OrderingRuleChildrenController::class)
        ->name('children');

    Route::apiResource('translation', OrderingRuleTranslationController::class)->only(['show','update']);

    Route::apiResource('child', OrderingRuleChildController::class)
        ->only(['store', 'destroy']);

    Route::prefix('conditions')
        ->as('conditions.')
        ->group(function () {
            Route::get('', OrderingConditionsController::class)->name('list');
        });
});

Route::apiResource('ordering-rule', OrderingRuleController::class);

Route::prefix('ordering-condition/{ordering_condition}')->as('ordering-condition.')
    ->group(function () {
        Route::apiResource('item', OrderingConditionItemController::class)
            ->only(['destroy', 'store']);
    });

Route::apiResource('ordering-condition', OrderingConditionController::class)
    ->except(['index']);
