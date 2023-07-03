<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\kfarat\Auth\LoginController;
use App\Http\Controllers\kfarat\HomeController;
use App\Http\Controllers\kfarat\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('kfarat')->name('kfarat.')->group(function() {
    Route::prefix('auth')->name('auth.')->controller(LoginController::class)->group(function() {
        Route::get('/login','login_view')->name('login.view');
        Route::post('/login','login')->name('login.submit');

        Route::get('/register','register_view')->name('register.view');
        Route::post('/register','register_view')->name('register.submit');

        //forgot Password urls needed
    });

    Route::prefix('home')->name('home.')->controller(HomeController::class)->group(function() {
        Route::get('/home','index')->name('index');
    })->middleware('auth');

    Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function() {

    })->middleware('auth');
});
