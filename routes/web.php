<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('guests.home');
});

Auth::routes();

Route::prefix('admin')
->middleware('auth')
->namespace('Admin')
->name('admin.')
->group(function(){
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::resource('dishes', DishController::class);

    Route::resource('orders', OrderController::class)->only('index', 'show');
});


Route::prefix('guest')

->namespace('Guest')
->group(function(){
    Route::resource('user', 'UserController')->only('show');
    Route::get('/cart', 'CartController@cart')->name('cart');
    
    Route::get('/payment/success', 'PaymentController@done')->name('payment.success');
    Route::get('/payment', 'PaymentController@index')->name('payment.index');
    Route::post('/payment', 'PaymentController@checkout')->name('payment.checkout');;
});