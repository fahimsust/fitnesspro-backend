<?php

use App\Api\Accounts\Controllers\AccountController;
use App\Api\Accounts\Controllers\AlbumController;
use App\Api\Accounts\Controllers\CellphoneController;
use App\Api\Accounts\Controllers\EmailController;
use App\Api\Accounts\Controllers\PhotoController;
use App\Api\Accounts\Controllers\TripController;
use App\Api\Events\Controllers\EventsController;
use App\Api\Help\Controllers\SupportController;
use App\Api\Resort\Controllers\ResortController;
use Illuminate\Support\Facades\Route;

Route::prefix('mobile/')->group(function () {
    Route::prefix('firebase')->name('firebase.')->group(function () {
        Route::resource('auth', \App\Api\Accounts\Controllers\Auth\Firebase\AuthController::class)
            ->only(['show', 'store', 'create']);
    });

    Route::middleware([
        'strip.html.api',
    ])
        ->name('mobile.')
        ->group(function () {
            Route::middleware([
                'auth:firebase',
                'account.api.verify',
            ])->group(function () {
                //any account specific controllers can go in this group

                Route::apiResource('account', AccountController::class);
                Route::apiResource('support', SupportController::class)->only(['store']);
                Route::apiResource('resort', ResortController::class)->only(['index', 'show']);

                Route::name('account.')->prefix('account/{account}')->group(function () {
                    Route::apiResource('email', EmailController::class)->only(['index', 'store']);
                    Route::apiResource('cellphone', CellphoneController::class)->only(['index', 'store']);

                    Route::apiResource('trip', TripController::class)->only(['index', 'show']);

                    Route::apiResource('album', AlbumController::class)->only(['index']);
                    Route::apiResource('photo', PhotoController::class)->only(['store']);
                });
            });

            Route::apiResource('event', EventsController::class);
        });
});
