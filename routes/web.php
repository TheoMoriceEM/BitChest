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

Route::middleware('auth', 'balance')->group(function () {
    Route::get('/', 'CurrencyController@index')->name('home');
    Route::get('/home', 'CurrencyController@index');

    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('/', 'CurrencyController@index')->name('index');
        Route::middleware('client')->get('/{currency}', 'CurrencyController@show')->name('show');
    });

    Route::middleware('client')->prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/{currency?}', 'TransactionController@index')->name('index');
        Route::get('/create/{currency}', 'TransactionController@create')->name('create');
        Route::post('/', 'TransactionController@store')->name('store');
        Route::patch('/{currency}/{transaction?}', 'TransactionController@update')->name('update');
        Route::get('/sell/{currency}', 'TransactionController@sell')->name('sell');
    });

    Route::middleware('admin')->resource('users', 'UserController')->except(['show']);

    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/edit', 'UserController@editAccount')->name('edit');
        Route::patch('/{user}', 'UserController@updateAccount')->name('update');
    });

    Route::middleware('client')->get('/wallet', 'WalletController@index')->name('wallet');
});

Route::prefix('api')->name('api.')->group(function () {
    Route::get('/get-price/{fsym}', function ($fsym) {
        $api = new App\API;
        return $api->getPrice($fsym);
    })->name('get-price');
});

Auth::routes();
