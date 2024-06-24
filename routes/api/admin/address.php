<?php

use App\Api\Admin\Addresses\Controllers\AddressController;
use Illuminate\Support\Facades\Route;

Route::apiResource('address', AddressController::class);
