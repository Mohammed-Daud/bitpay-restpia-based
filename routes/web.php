<?php

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

Route::post('pay','BitPayController@pay')->name('pay');
Route::post('ipn','BitPayController@ipn')->name('ipn');
Route::get('thankyou', 'BitPayController@redirect');
Route::get('payment_status', 'BitPayController@payment_status');



