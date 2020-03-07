<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use App\API;

class CurrencyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->composer('layouts.layout', function ($view) {
            $view->with('section', 'currencies');
        });
    }

    /**
     * Display the currencies list with their current rate.
     */
    public function index(API $api)
    {
        $currencies = Currency::all(); // Get cryptocurrencies from DB

        $data = $api->getMultipleData($currencies->pluck('api_id')->implode(',')); // Get data from API

        // Loop through all cryptocurrencies to add the wanted data
        foreach ($currencies as $currency) {
            $currency_data = $data[$currency->api_id];
            $currency->current_rate = $currency_data['current_rate'];
            $currency->change = $currency_data['change'];
        }

        return view('currencies.index', ['currencies' => $currencies]);
    }

    /**
     * Display a currency's rate history.
     */
    public function show(Currency $currency, API $api)
    {
        $days = $api->getHistory($currency->api_id);

        return view('currencies.show', [
            'title' => 'Historique du ' . $currency->name,
            'currency' => $currency,
            'days' => $days
        ]);
    }
}
