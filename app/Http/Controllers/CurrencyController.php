<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Currency;
use Carbon\Carbon;

class CurrencyController extends Controller
{
    protected $client;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Initialize Guzzle for API calls
        $this->client = new Client([
            'base_uri' => 'https://min-api.cryptocompare.com'
        ]);
    }

    /**
     * Display the currencies list with their current rate.
     */
    public function index()
    {
        $currencies = Currency::all(); // Get cryptocurrencies from DB
        $conversion_currency = config('currency')['api_id']; // Get the real currency for conversion

        // Request to API for getting cryptocurrencies' data
        $response = $this->client->get('data/pricemultifull', [
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
    public function show(Currency $currency)
    {
        // Request to API for getting cryptocurrency's history
        $response = $this->client->get('data/v2/histoday', [
            'query' => [
                'fsym'  => $currency->api_id, // Cryptocurrency's identifier
                'tsym'  => config('currency')['api_id'], // Real currency to convert rate to
                'limit' => 29 // Number of past days to retrieve
            ]
        ]);

        $data = json_decode($response->getBody())->Data->Data; // Get data from JSON
        $days = [];

        // Loop through days to retrieve the wanted data for each one of them
        foreach ($data as $index => $day) {
            $date = new Carbon($day->time);
            $days[$index]['date'] = $date->format('d/m'); // Format the date
            $days[$index]['rate'] = $day->open; // Rate at the date
        }

        return view('currencies.show', [
            'title' => 'Historique du ' . $currency->name,
            'currency' => $currency,
            'days' => $days
        ]);
    }
}
