<?php
use App\Api\Admin\Reports\Controllers\CustomerReportController;
use App\Api\Admin\Reports\Controllers\CustomerReportDownloadController;
use Illuminate\Support\Facades\Route;

Route::prefix('report')->as('report.')->group(function () {
    Route::prefix('customer/{report}')->as('customer.')->group(function () {
        Route::get('download-excel', [CustomerReportDownloadController::class, 'downloadExcel'])->name('download-excel');
        Route::get('download-csv', [CustomerReportDownloadController::class, 'downloadCsv'])->name('download-csv');
    });
    Route::apiResource('customer', CustomerReportController::class);
});



