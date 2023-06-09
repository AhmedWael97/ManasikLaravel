<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

Route::get('/Logout','App\Http\Controllers\AuthController@logout')->name('Logout');

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


//Wallet
Route::prefix('/Wallet')->group(function() {
    Route::get('/index','App\Http\Controllers\WalletController@index')->name('Wallet');
    Route::get('/create','App\Http\Controllers\WalletController@create')->name('Wallet-Create');
    Route::post('/store','App\Http\Controllers\WalletController@store')->name('Wallet-Store');
    Route::get('/edit/{id}','App\Http\Controllers\WalletController@edit')->name('Wallet-Edit');
    Route::post('/update','App\Http\Controllers\WalletController@update')->name('Wallet-Update');
    Route::get('/delete/{id}','App\Http\Controllers\WalletController@destroy')->name('Wallet-Delete');
});


//Country
Route::prefix('country')->group(function() {
    Route::get('/index','App\Http\Controllers\CountryController@index')->name('country-index');
    Route::get('/create','App\Http\Controllers\CountryController@create')->name('country-create');
    Route::post('/store','App\Http\Controllers\CountryController@store')->name('country-store');
    Route::get('/edit/{id}','App\Http\Controllers\CountryController@edit')->name('country-edit');
    Route::post('/update','App\Http\Controllers\CountryController@update')->name('country-update');
    Route::get('/delete/{id}','App\Http\Controllers\CountryController@destroy')->name('country-delete');
});

//Currency
Route::prefix('currency')->group(function() {
    Route::get('/index','App\Http\Controllers\CurrencyController@index')->name('currency-index');
    Route::get('/create','App\Http\Controllers\CurrencyController@create')->name('currency-create');
    Route::post('/store','App\Http\Controllers\CurrencyController@store')->name('currency-store');
    Route::get('/edit/{id}','App\Http\Controllers\CurrencyController@edit')->name('currency-edit');
    Route::post('/update','App\Http\Controllers\CurrencyController@update')->name('currency-update');
    Route::get('/delete/{id}','App\Http\Controllers\CurrencyController@destroy')->name('currency-delete');
});
//Gender
Route::prefix('gender')->group(function() {
    Route::get('/index','App\Http\Controllers\GenderController@index')->name('gender-index');
    Route::get('/create','App\Http\Controllers\GenderController@create')->name('gender-create');
    Route::post('/store','App\Http\Controllers\GenderController@store')->name('gender-store');
    Route::get('/edit/{id}','App\Http\Controllers\GenderController@edit')->name('gender-edit');
    Route::post('/update','App\Http\Controllers\GenderController@update')->name('gender-update');
    Route::get('/delete/{id}','App\Http\Controllers\GenderController@destroy')->name('gender-delete');
});
//Jobs
Route::prefix('job')->group(function() {
    Route::get('/index','App\Http\Controllers\JobController@index')->name('job-index');
    Route::get('/create','App\Http\Controllers\JobController@create')->name('job-create');
    Route::post('/store','App\Http\Controllers\JobController@store')->name('job-store');
    Route::get('/edit/{id}','App\Http\Controllers\JobController@edit')->name('job-edit');
    Route::post('/update','App\Http\Controllers\JobController@update')->name('job-update');
    Route::get('/delete/{id}','App\Http\Controllers\JobController@destroy')->name('job-delete');
});
//Language
Route::prefix('language')->group(function() {
    Route::get('/index','App\Http\Controllers\LanguageController@index')->name('language-index');
    Route::get('/create','App\Http\Controllers\LanguageController@create')->name('language-create');
    Route::post('/store','App\Http\Controllers\LanguageController@store')->name('language-store');
    Route::get('/edit/{id}','App\Http\Controllers\LanguageController@edit')->name('language-edit');
    Route::post('/update','App\Http\Controllers\LanguageController@update')->name('language-update');
    Route::get('/delete/{id}','App\Http\Controllers\LanguageController@destroy')->name('language-delete');
});


//Nationality
Route::prefix('nationality')->group(function() {
    Route::get('/index','App\Http\Controllers\NationalityController@index')->name('nationality-index');
    Route::get('/create','App\Http\Controllers\NationalityController@create')->name('nationality-create');
    Route::post('/store','App\Http\Controllers\NationalityController@store')->name('nationality-store');
    Route::get('/edit/{id}','App\Http\Controllers\NationalityController@edit')->name('nationality-edit');
    Route::post('/update','App\Http\Controllers\NationalityController@update')->name('nationality-update');
    Route::get('/delete/{id}','App\Http\Controllers\NationalityController@destroy')->name('nationality-delete');

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
    Route::get('/auto-assign/{id}','App\Http\Controllers\UserController@automateAssign')->name('Users-auto');
    Route::post('/auto/assign/store','App\Http\Controllers\UserController@saveAutoAssign')->name('Users-Store-Auto');
});



//Services
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


//KfaratChoice
Route::prefix('/KfaratChoice')->group(function() {
    Route::get('/index','App\Http\Controllers\KfaratChoiceController@index')->name('KfaratChoice');
    Route::get('/create','App\Http\Controllers\KfaratChoiceController@create')->name('KfaratChoice-Create');
    Route::post('/store','App\Http\Controllers\KfaratChoiceController@store')->name('KfaratChoice-Store');
    Route::get('/edit/{id}','App\Http\Controllers\KfaratChoiceController@edit')->name('KfaratChoice-Edit');
    Route::post('/update','App\Http\Controllers\KfaratChoiceController@update')->name('KfaratChoice-Update');
    Route::get('/delete/{id}','App\Http\Controllers\KfaratChoiceController@destroy')->name('KfaratChoice-Delete');
});

//PaymentTypes
Route::prefix('/PaymentTypes')->group(function() {
    Route::get('/index','App\Http\Controllers\PaymentTypeController@index')->name('PaymentTypes');
    Route::get('/create','App\Http\Controllers\PaymentTypeController@create')->name('PaymentTypes-Create');
    Route::post('/store','App\Http\Controllers\PaymentTypeController@store')->name('PaymentTypes-Store');
    Route::get('/edit/{id}','App\Http\Controllers\PaymentTypeController@edit')->name('PaymentTypes-Edit');
    Route::post('/update','App\Http\Controllers\PaymentTypeController@update')->name('PaymentTypes-Update');
    Route::get('/delete/{id}','App\Http\Controllers\PaymentTypeController@destroy')->name('PaymentTypes-Delete');
});


//HajPurpose
Route::prefix('/HajPurpose')->group(function() {
    Route::get('/index','App\Http\Controllers\HajPurposeController@index')->name('HajPurpose');
    Route::get('/create','App\Http\Controllers\HajPurposeController@create')->name('HajPurpose-Create');
    Route::post('/store','App\Http\Controllers\HajPurposeController@store')->name('HajPurpose-Store');
    Route::get('/edit/{id}','App\Http\Controllers\HajPurposeController@edit')->name('HajPurpose-Edit');
    Route::post('/update','App\Http\Controllers\HajPurposeController@update')->name('HajPurpose-Update');
    Route::get('/delete/{id}','App\Http\Controllers\HajPurposeController@destroy')->name('HajPurpose-Delete');
});


//Status
Route::prefix('/Status')->group(function() {
    Route::get('/index','App\Http\Controllers\StatusController@index')->name('Status');
    Route::get('/create','App\Http\Controllers\StatusController@create')->name('Status-Create');
    Route::post('/store','App\Http\Controllers\StatusController@store')->name('Status-Store');
    Route::get('/edit/{id}','App\Http\Controllers\StatusController@edit')->name('Status-Edit');
    Route::post('/update','App\Http\Controllers\StatusController@update')->name('Status-Update');
    Route::get('/delete/{id}','App\Http\Controllers\StatusController@destroy')->name('Status-Delete');
});

//Orders
Route::prefix('/Orders')->group(function() {
    Route::get('/index','App\Http\Controllers\OrderController@index')->name('Orders');
    Route::get('/show/{id}','App\Http\Controllers\OrderController@show')->name('Orders-Show');
    Route::get('/create','App\Http\Controllers\OrderController@create')->name('Orders-Create');
    Route::post('/store','App\Http\Controllers\OrderController@store')->name('Orders-Store');
    Route::get('/edit/{id}','App\Http\Controllers\OrderController@edit')->name('Orders-Edit');
    Route::post('/update','App\Http\Controllers\OrderController@update')->name('Orders-Update');
    Route::get('/delete/{id}','App\Http\Controllers\OrderController@destroy')->name('Orders-Delete');
    Route::post('chanage-status','App\Http\Controllers\OrderController@changeStatus')->name('ChangeStatus');
    Route::post('/AssignExecuter','App\Http\Controllers\OrderController@AssignExecuter')->name('AssignExecuter');
});

=
//Requests to do
Route::prefix('/RequestToDo')->group(function() {
    Route::get('/index','App\Http\Controllers\RequestToDoController@index')->name('RequestToDo');
    Route::post('/accept/{id}','App\Http\Controllers\RequestToDoController@accept')->name('RequestToDo-accept');
    Route::post('/refused/{id}','App\Http\Controllers\RequestToDoController@refused')->name('RequestToDo-refused');

});



Route::get('/test',function() {
    return AssignServicesToExecuters();
});

Route::get('/return-count-admin' ,'App\Http\Controllers\UserController@getAdminCount');
Route::get('/return-count-mobilApp' ,'App\Http\Controllers\UserController@getMobilAppCount');
Route::get('/return-count-executer-dashboard' ,'App\Http\Controllers\UserController@getExecuterDashboardNo');
Route::get('/return-count-executer-app' ,'App\Http\Controllers\UserController@getExecuterAppNo');
