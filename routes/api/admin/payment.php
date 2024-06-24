<?php

use App\Api\Admin\PaymentAccounts\Controllers\PaymentAccountController;
use App\Api\Admin\PaymentMethods\Controllers\PaymentMethodController;
use Illuminate\Support\Facades\Route;

Route::apiResource('payment-account', PaymentAccountController::class)->only('index');
Route::apiResource('payment-method', PaymentMethodController::class)->only('index');
