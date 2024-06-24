<?php

use App\Api\Admin\BulkEdit\Controllers\FindController;
use App\Api\Admin\BulkEdit\Controllers\PerformController;
use Illuminate\Support\Facades\Route;

Route::apiResource('bulk-edit-find',FindController::class)->only(['index','store']);
Route::apiResource('bulk-edit-perform',PerformController::class)->only(['index','store']);
