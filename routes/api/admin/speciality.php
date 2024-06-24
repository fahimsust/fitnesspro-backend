<?php
use App\Api\Admin\Speciality\Controllers\AllSpecialityController;
use App\Api\Admin\Speciality\Controllers\SpecialitiesController;
use Illuminate\Support\Facades\Route;

Route::prefix('specialities')->as('specialities.')->group(function () {
    Route::get('', SpecialitiesController::class)->name('list');
    Route::get('all', AllSpecialityController::class)->name('all');
});
