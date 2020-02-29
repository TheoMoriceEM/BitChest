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
        $currencies = Currency::all(); // Get cryptocurrencies from DB
        $conversion_currency = config('currency')['api_id']; // Get the real currency for conversion

        // Initialize Guzzle for API calls
        $client = new Client([
            'base_uri' => 'https://min-api.cryptocompare.com'
        ]);

        // Request to API for getting cryptocurrencies' data
        $response = $client->get('data/pricemultifull', [
            'query' => [
                'fsyms' => $currencies->pluck('api_id')->implode(','), // Cryptocurrencies' identifiers
                'tsyms' => $conversion_currency // Real currency to convert rate to
            ]
        ]);

        $data = json_decode($response->getBody())->RAW; // Get data from JSON

        // Loop through all cryptocurrencies to add the wanted data
        foreach ($currencies as $currency) {
            $api_id = $currency->api_id;
            $currency_data = $data->$api_id->$conversion_currency; // Target the right data

            $currency->current_rate = $currency_data->PRICE; // Get current rate
            $currency->change = $currency_data->CHANGE24HOUR > 0 ? '+' : '-'; // Get the evolution on the last 24h : positive or negative
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
