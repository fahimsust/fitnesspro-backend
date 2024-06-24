<?php

use App\Api\Accounts\Controllers\Auth\Sanctum\AuthController;
use App\Api\Accounts\Controllers\Registration\CompleteController;
use App\Api\Accounts\Controllers\Registration\PayCompleteController;
use App\Api\Accounts\Controllers\Registration\RecoveryController;
use App\Api\Accounts\Controllers\Registration\RegistrationAffiliateController;
use App\Api\Accounts\Controllers\Registration\RegistrationBillingAddressController;
use App\Api\Accounts\Controllers\Registration\RegistrationDiscountController;
use App\Api\Accounts\Controllers\Registration\RegistrationPaymentMethodController;
use App\Api\Accounts\Controllers\Registration\SelectMembershipLevelController;
use App\Api\Accounts\Controllers\Registration\StartController;
use Illuminate\Support\Facades\Route;

Route::prefix('registration')->as('registration.')->group(function () {
    Route::controller(StartController::class)->group(function () {
        Route::post('/', 'store')->name('start');
        Route::get('show', 'show')->name('show');
    });

    Route::prefix('recovery')->as('recovery.')
        ->controller(RecoveryController::class)->group(function () {
            Route::get('recover/{recovery_hash}', 'show')->name('recover');
            Route::post('/', 'store')->name('hash');
        });

    //@fahim - kebab-case for uri fragments please
    Route::prefix('membership-level')->as('level.')
        ->controller(SelectMembershipLevelController::class)->group(function () {
            Route::get('/', 'index')->name('view');
            Route::post('/', 'store')->name('store');
            Route::get('current', 'show')->name('show');
        });

    Route::prefix('payment-method')->as('payment-method.')
        ->controller(RegistrationPaymentMethodController::class)->group(function () {
            Route::get('/', 'index')->name('view');
            Route::post('/', 'store')->name('store');
            Route::get('current', 'show')->name('show');
        });

    Route::prefix('affiliate')->as('affiliate.')
        ->controller(RegistrationAffiliateController::class)->group(function () {
            Route::post('/', 'store')->name('store');
            Route::get('/', 'show')->name('show');
        });

    Route::prefix('discount')->as('discount.')
        ->controller(RegistrationDiscountController::class)->group(function () {
            Route::get('/', 'index')->name('view');
            Route::post('/', 'store')->name('store');
            Route::delete('/', 'delete')->name('delete');
        });

    Route::prefix('billing-address')->as('billing-address.')
        ->controller(RegistrationBillingAddressController::class)->group(function () {
            Route::get('/', 'index')->name('all');
            Route::post('/', 'store')->name('store');
            Route::get('show', 'show')->name('show');
            Route::put('/', 'update')->name('change');
        });

    Route::prefix('order')->as('order.')
        ->controller(PayCompleteController::class)
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::put('complete', 'update')->name('complete');
            Route::get('current', 'show')->name('show');
        });
});

Route::middleware('auth:sanctum')
    ->get('/user', [AuthController::class, 'me'])
    ->name('account.me');
