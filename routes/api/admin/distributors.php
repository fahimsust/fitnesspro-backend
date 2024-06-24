<?php

use App\Api\Admin\Products\Controllers\DistributorsController;
use Illuminate\Support\Facades\Route;

Route::get('distributors', DistributorsController::class)->name('distributors');
