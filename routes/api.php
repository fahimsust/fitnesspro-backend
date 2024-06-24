<?php

use App\Api\Accounts\Controllers\Auth\ForgotPasswordController;
use App\Api\Accounts\Controllers\Auth\ForgotUsernameController;
use App\Api\Accounts\Controllers\Auth\ResetPasswordController;
use App\Api\Support\Controllers\SupportEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('slug/{slug}', [\App\Api\Slugs\Controllers\ParseController::class, 'show']);

require 'api/admin.php';

require 'api/registration.php';
require 'api/address.php';
require 'api/login.php';
require 'api/payment.php';
require 'api/products.php';
require 'api/cart.php';
require 'api/checkout.php';
require 'api/review.php';
require 'api/faq.php';

require 'api/mobile.php';
require 'api/support.php';

Route::middleware(['strip.html.api', 'throttle:3,10'])->group(function () {
    Route::post('forgot-password', ForgotPasswordController::class)->name('account.forgot-password');
    Route::post('reset-password', ResetPasswordController::class)->name('account.reset-password');
    Route::post('forgot-username', ForgotUsernameController::class)->name('account.forgot-username');
});
Route::prefix('support')->as('support.')->group(function () {
    Route::controller(SupportEmailController::class)->group(function () {
        Route::get('/', 'index')->name('departments');
        Route::post('/send', 'send')->name('send-email');
    });
});
