<?php

use App\Api\Addresses\Controllers\UpdateAddressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('account_address', UpdateAddressController::class)->only('update');
