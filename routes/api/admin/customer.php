<?php

use App\Api\Admin\MemberShipLevels\Controllers\MemberShipLevelController;
use App\Api\Admin\MemberShipLevels\Controllers\MemberShipLevelsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('membership-level', MemberShipLevelController::class)->only('index');
Route::apiResource('membership-levels', MemberShipLevelsController::class)->only('index');
