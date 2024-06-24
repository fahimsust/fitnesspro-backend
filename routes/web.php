<?php

use App\Api\Accounts\Controllers\Auth\Sanctum\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-legacy', function () {
    DB::connection('legacy')->getPdo();

    return "Connected!";
});

Route::get('auth/ups', function () {
    $clientId = config('services.ups.client_id');
    $redirectUri = config('services.ups.redirect_uri');

    $query = array(
        "client_id" => $clientId,
        "redirect_uri" => $redirectUri,
        "response_type" => "code",
    );

    return redirect(
        Http::withoutRedirecting()
            ->get(\Domain\Orders\Services\Shipping\Ups\Enums\Modes::Test->url()
                . 'security/v1/oauth/authorize', $query)
            ->header('Location')
    );
    //            ->then(
    //                fn($response) => <<<TEXT
    //https://www.ups.com/lasso/signin?client_id={$clientId}&redirect_uri={$redirectUri}&response_type=code&scope=read&type=ups_com_api
    //TEXT
    //    );
});

Route::get('auth/ups/return', function () {
    //https://v3-api.fitnessprotravel.com/auth/ups/return?code=Mk43VnZNR0UtVTJGc2RHVmtYMTg3eHJaMUxzYzg0ZnVRR3cyeGwrR2tEWkFVb0ZVSjY5UTlVeWNrYVcvU280RkpoYVhza2hxN3JNK3B1c1J6RXZxeWRkTGlteDFQdnc9PQ==&scope=read
    dd(request());
});
Route::prefix('api/')->name('account.')->group(
    function () {
        Route::post('/login', [AuthController::class, 'store'])->name('login');
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    }
);
