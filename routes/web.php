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

Route::middleware('auth')->group(function () {
    Route::get('/', 'CurrencyController@index')->name('home');
    Route::get('/home', 'CurrencyController@index')->name('home');

    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('/', 'CurrencyController@index')->name('index');
        Route::get('/{currency}', 'CurrencyController@show')->name('show');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/create/{currency}', 'TransactionController@create')->name('create');
        Route::post('/', 'TransactionController@store')->name('store');
    });
});

Auth::routes();
