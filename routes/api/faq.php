<?php

use App\Api\Faqs\Controllers\FaqsController;
use Illuminate\Support\Facades\Route;

Route::prefix('faq')->as('faq.')->group(function () {
    Route::get('', FaqsController::class)->name('list');
});
