<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    if(Auth::check()) {
        return redirect('/home');
    }
    return view('Auth.login');
})->name('login');

// Auth
Route::post('/login','App\Http\Controllers\AuthController@login')->name('Login');

//home
Route::get('/home','App\Http\Controllers\HomeController@home')->name('Home');

//Roles
Route::prefix('/Roles')->group(function() {
    Route::get('/index','App\Http\Controllers\RoleController@index')->name('Roles');
    Route::get('/create','App\Http\Controllers\RoleController@create')->name('Roles-Create');
    Route::post('/store','App\Http\Controllers\RoleController@store')->name('Roles-Store');
    Route::get('/edit/{id}','App\Http\Controllers\RoleController@edit')->name('Roles-Edit');
    Route::post('/update','App\Http\Controllers\RoleController@update')->name('Roles-Update');
    Route::get('/delete/{id}','App\Http\Controllers\RoleController@destroy')->name('Roles-Delete');
});


//Users
Route::prefix('/Users')->group(function() {
    Route::get('/index','App\Http\Controllers\UserController@index')->name('Users');
    Route::get('/view/{id}','App\Http\Controllers\UserController@view')->name('Users-View');
    Route::get('/create','App\Http\Controllers\UserController@create')->name('Users-Create');
    Route::post('/store','App\Http\Controllers\UserController@store')->name('Users-Store');
    Route::get('/edit/{id}','App\Http\Controllers\UserController@edit')->name('Users-Edit');
    Route::post('/update','App\Http\Controllers\UserController@update')->name('Users-Update');
    Route::get('/delete/{id}','App\Http\Controllers\UserController@destroy')->name('Users-Delete');
});



//Users
Route::prefix('/Services')->group(function() {
    Route::get('/index','App\Http\Controllers\ServiceController@index')->name('Services');
    Route::get('/view/{id}','App\Http\Controllers\ServiceController@view')->name('Services-View');
    Route::get('/create','App\Http\Controllers\ServiceController@create')->name('Services-Create');
    Route::post('/store','App\Http\Controllers\ServiceController@store')->name('Services-Store');
    Route::get('/edit/{id}','App\Http\Controllers\ServiceController@edit')->name('Services-Edit');
    Route::post('/update','App\Http\Controllers\ServiceController@update')->name('Services-Update');
    Route::get('/delete/{id}','App\Http\Controllers\ServiceController@destroy')->name('Services-Delete');
    Route::get('/delete/step/{id}','App\Http\Controllers\ServiceController@destroyStep')->name('Services-Delete-step');
});
