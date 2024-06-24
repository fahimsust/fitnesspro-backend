<?php

use App\Api\Admin\Users\Controllers\Auth\ForgotPasswordController;
use App\Api\Admin\Users\Controllers\Auth\ResetPasswordController;
use App\Api\Admin\Users\Controllers\Auth\Sanctum\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin/')->name('admin.')->group(function () {
    Route::middleware('web')->controller(AuthController::class)->group(function () {
        Route::post('login', 'login')->name('login');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/user', [AuthController::class, 'me'])
            ->name('me');

        require 'admin/category.php';
        require 'admin/order.php';
        require 'admin/product.php';
        require 'admin/product_type.php';
        require 'admin/product_option.php';
        require 'admin/site.php';
        require 'admin/account.php';
        require 'admin/attribute.php';
        require 'admin/content.php';
        require 'admin/reviews.php';
        require 'admin/ordering_rule.php';
        require 'admin/brand.php';
        require 'admin/affiliate.php';
        require 'admin/address.php';
        require 'admin/distributors.php';
        require 'admin/pricing_rule.php';
        require 'admin/ful_fillment_rule.php';
        require 'admin/custom_form.php';
        require 'admin/accessory_field.php';
        require 'admin/tax_rule.php';
        require 'admin/account_type.php';
        require 'admin/message_template.php';
        require 'admin/speciality.php';
        require 'admin/payment.php';
        require 'admin/bulk_edit.php';
        require 'admin/discount.php';
        require 'admin/customer.php';
        require 'admin/faq.php';
        require 'admin/report.php';
    });

    Route::middleware(['guest:admin', 'strip.html.api', 'throttle:3,10'])->group(function () {
        Route::post('forgot-password', ForgotPasswordController::class)->name('forgot-password');
        Route::post('reset-password', ResetPasswordController::class)->name('reset-password');
    });
});
