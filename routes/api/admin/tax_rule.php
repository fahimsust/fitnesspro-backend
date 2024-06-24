<?php

use App\Api\Admin\TaxRules\Controllers\TaxRulesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tax_rules', TaxRulesController::class)->only('index');
