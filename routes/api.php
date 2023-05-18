<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\V1\AuthenticateController;
use App\Http\Controllers\API\V1\BasicController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\PaymentController;
use App\Http\Controllers\API\V1\UserController;
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
            Route::get('/getServices-auth','getServices')->middleware('auth:sanctum');
            Route::get('/getKfaratChoices','getKfaratChoices');
            Route::get('/getPaymentTypes','getPaymentTypes');
            Route::get('/getHajPurpose','getHajPurpose');
        });
    });

    Route::prefix('order')->group(function() {
        Route::controller(OrderController::class)->group(function() {
            Route::post('/store','store')->middleware('auth:sanctum');
            Route::get('/details/{id}','orderDetails')->middleware('auth:sanctum');
            Route::get('/orderDetail/{order_id}/steps/{service_id}','orderDetailStep')->middleware('auth:sanctum');
            Route::get('/myOrders','myOrders')->middleware('auth:sanctum');
            Route::get('/cancel-my-order/{order_id}','cancelMyOrder')->middleware('auth:sanctum');
            Route::get('/my_order_steps/{order_detail_id}','my_order_steps');
            Route::post('/ask_image','ask_image')->middleware('auth:sanctum');;
            Route::post('/ask_live_location','ask_live_location')->middleware('auth:sanctum');
        });
    });

    Route::prefix('wallet')->group(function() {
        Route::controller(PaymentController::class)->group(function() {
            Route::get('/history','MyBalanceHistory')->middleware('auth:sanctum');
        });
    });

    Route::prefix('user')->group(function() {
        Route::controller(UserController::class)->group(function() {
            Route::get('/myInfo','getMyInfo')->middleware('auth:sanctum');
            Route::post('/updateMyInfo','UpdateMyInfo')->middleware('auth:sanctum');
        });
    });

    Route::prefix('executer')->group(function() {
        Route::prefix('auth')->group(function() {
            Route::controller(AuthenticateController::class)->group(function(){
                Route::post('/executer-login','executer_login');
                Route::post('/executer-register','executer_register');
            });
        });
        Route::prefix('order')->group(function() {
            Route::controller(OrderController::class)->group(function() {
                Route::get('/available-orders','executer_avaliavble_orders');
                Route::post('/request-to-do','request_to_take_order');
                Route::get('/my-requests/{status}','my_to_do_requests');
                Route::post('/start_step','startSteps');
                Route::post('/end_step','end_step');
                Route::post('/send_image','send_image');
                Route::post('/send_live_location','send_live_loction');
            });
        });
    });
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
