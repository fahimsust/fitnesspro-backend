<?php

use App\Api\Admin\FulfillmentRules\Controllers\FulfillmentRulesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('ful-fillment-rules', FulfillmentRulesController::class)->only('index');
