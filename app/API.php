<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Carbon\Carbon;

class API extends Model
{
    protected $client;
    protected $conversion_currency;

    /**
     * Instantiate a new model instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Initialize Guzzle for API calls
        $this->client = new Client([
            'base_uri' => 'https://min-api.cryptocompare.com'
        ]);

        $this->conversion_currency = config('currency')['api_id']; // Real currency used for conversion
    }

    /**
     * Get a single cryptocurrency's current price.
     */
    public function getPrice($fsym)
    {
        $conversion_currency = $this->conversion_currency;

        $response = $this->client->get('data/price', [
            'query' => [
                'fsym' => $fsym, // Cryptocurrency whose price we want
                'tsyms' => $conversion_currency // Real currency to convert the price to
            ]
        ]);

        $price = json_decode($response->getBody())->$conversion_currency; // Get data from JSON

        return $price;
    }

    /**
     * Get several cryptocurrencies' data: current price + change on the last 24h
     */
    public function getMultipleData($fsyms)
    {
        $conversion_currency = $this->conversion_currency;
        $filtered_data = [];

        $response = $this->client->get('data/pricemultifull', [
            'query' => [
                'fsyms' => $fsyms, // Cryptocurrencies whose data we want
                'tsyms' => $this->conversion_currency // Real currency to convert the price to
            ]
        ]);

        $data = json_decode($response->getBody())->RAW; // Get data from JSON

        // Filter API data to keep only relevent data
        foreach ($data as $api_id => $currency) {
            $filtered_data[$api_id] = [
                'current_rate' => $currency->$conversion_currency->PRICE, // Get current price
                'change' => $currency->$conversion_currency->CHANGE24HOUR > 0 ? '+' : '-' // Get the evolution on the last 24h : positive or negative
            ];
        }

        return $filtered_data;
    }

    /**
     * Get a single cryptocurrency's price history
     */
    public function getHistory($fsym, $limit = 29)
    {
        $filtered_data = [];

        $response = $this->client->get('data/v2/histoday', [
            'query' => [
                'fsym'  => $fsym, // Cryptocurrency whose data we want
                'tsym'  => $this->conversion_currency, // Real currency to convert the price to
                'limit' => $limit // Number of past days to retrieve
            ]
        ]);

        $data = json_decode($response->getBody())->Data->Data; // Get data from JSON

        // Filter API data to keep only relevent data
        foreach ($data as $index => $day) {
            $date = new Carbon($day->time);
            $filtered_data[$index]['date'] = $date->format('d/m'); // Format the date
            $filtered_data[$index]['rate'] = $day->open; // Price at the date
        }

        return $filtered_data;
    }
}
