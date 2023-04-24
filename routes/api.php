<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\AuthenticateController;
use App\Http\Controllers\API\V1\BasicController;
use App\Http\Controllers\API\V1\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::controller(AuthenticateController::class)->group(function(){
            Route::post('/login','login');
            Route::post('/register','register');
        });
    });

    Route::prefix('basic')->group(function() {
        Route::controller(BasicController::class)->group(function() {
            Route::get('/getMyAccountData','getMyAccountData');
            Route::get('/getCountries','getCountries');
            Route::get('/getCurrency','getCurrency');
            Route::get('/getJob','getJob');
            Route::get('/getGender','getGender');
            Route::get('/getMyBalance','getMyBalance');
            Route::get('/getLangs','getLangs');
            Route::get('/getNationality','getNationality');
            Route::get('/getServices','getServices');
            Route::get('/getKfaratChoices','getKfaratChoices');
            Route::get('/getPaymentTypes','getPaymentTypes');
            Route::get('/getHajPurpose','getHajPurpose');
        });
    });

    Route::prefix('order')->group(function() {
        Route::controller(OrderController::class)->group(function() {
            Route::post('/store','store')->middleware('auth:sanctum');
            Route::get('/order/details/{id}','orderDetails')->middleware('auth:sanctum');
            Route::get('/orderDetail/{order_id}/steps/{service_id}','serviceSteps')->middleware('auth:sanctum');
        });
    });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
