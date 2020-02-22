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

        // Get their current rates through an API
        foreach ($currencies as $currency) {
            $client = new Client([
                'base_uri' => 'https://min-api.cryptocompare.com'
            ]);

            // Request to the API for getting the current rate
            $response = $client->get('data/price', [
                'query' => [
                    'fsym'  => $currency->api_id, // Currency's identifier
                    'tsyms' => config('currency')['api_id'] // Real currency used for conversion
                ]
            ]);

            // Get the rate from JSON response
            $conversion_currency = config('currency')['api_id'];
            $currency->current_rate = json_decode($response->getBody())->$conversion_currency;
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
