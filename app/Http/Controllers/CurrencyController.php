<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Currency;

class CurrencyController extends Controller
{
    /**
     * Display the currencies list with their current rate.
     */
    public function index()
    {
        $currencies = Currency::all(); // Get all the currencies
        $conversion_currency = config('currency')['api_id']; // Get the real currency for conversion

        $client = new Client([
            'base_uri' => 'https://min-api.cryptocompare.com'
        ]);

        // Request to an API for getting the current rates of all the currencies
        $response = $client->get('data/pricemulti', [
            'query' => [
                'fsyms' => $currencies->pluck('api_id')->implode(','), // Currencies identifiers
                'tsyms' => $conversion_currency // Real currency used for conversion
            ]
        ]);

        // Get the rates from JSON response and insert them into the models
        foreach ($currencies as $currency) {
            $api_id = $currency->api_id;
            $currency->current_rate = json_decode($response->getBody())->$api_id->$conversion_currency;
        }

        return view('currencies.index', ['currencies' => $currencies]);
    }

    /**
     * Display a currency's rate history.
     */
    public function show($id)
    {
        //
    }
}
