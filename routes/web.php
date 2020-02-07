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

Route::get('/', 'CurrencyController@index')->name('home');

Route::middleware('auth')->prefix('currencies')->name('currencies.')->group(function () {
    Route::get('/', 'CurrencyController@index')->name('index');
    Route::get('/{id}', 'CurrencyController@show')->name('show');
});

Auth::routes();
