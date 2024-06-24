<?php

use App\Api\Admin\PricingRules\Controllers\PricingRuleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('pricing-rule', PricingRuleController::class)->only('index');
