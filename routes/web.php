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
    Route::get('/home', 'CurrencyController@index');

    Route::prefix('currencies')->name('currencies.')->group(function () {
        Route::get('/', 'CurrencyController@index')->name('index');
        Route::get('/{currency}', 'CurrencyController@show')->name('show');
    });

    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/create/{currency}', 'TransactionController@create')->name('create');
        Route::post('/', 'TransactionController@store')->name('store');
        Route::get('/{currency?}', 'TransactionController@index')->name('index');
        Route::get('/sell/{currency}', 'TransactionController@sell')->name('sell');
        Route::patch('/{currency}/{transaction?}', 'TransactionController@update')->name('update');
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/create', 'UserController@create')->name('create');
        Route::post('/', 'UserController@store')->name('store');
        Route::get('/{user}/edit', 'UserController@edit')->name('edit');
        Route::get('/my-account', 'UserController@editMyAccount')->name('editMyAccount');
        Route::patch('/{user}', 'UserController@update')->name('update');
        Route::patch('/{user}', 'UserController@updateMyAccount')->name('updateMyAccount');
        Route::delete('/{user}', 'UserController@destroy')->name('destroy');
    });

    Route::get('/wallet', 'WalletController@index')->name('wallet');

    Route::get('apiGetPrice/{fsym}', function ($fsym) {
        $api = new App\API;
        return $api->getPrice($fsym);
    })->name('api.getPrice');
});

Auth::routes();
