<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\User;

class WalletController extends Controller
{
    protected $client;
    protected $data;
    protected $conversion_currency;
    protected $api_ids;

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

        $this->conversion_currency = config('currency')['api_id']; // Set real currency for conversion

        $this->api_ids = []; // Init an array for currencies' API IDs (for the API call)
    }

    /**
     * Display the user's wallet.
     */
    public function index()
    {
        $user = User::find(Auth::id()); // Get logged in user

        $currencies = $user
            ->transactions // Get user's transactions
            ->where('sold', 0) // Unsold
            ->groupBy('currency_id') // Group them by currency
            ->map(function ($row) {
                    $this->api_ids[] = $row->first()->currency->api_id; // Fill API IDs array for future API call
                    return [
                        'currency'          => $row->first()->currency,
                        'total_quantity'    => $row->sum('quantity'), // Calculate the total of this currency
                        'total_amount'      => $row->sum('amount') // Calculate the amount the user spent
                    ];
                });

        // API request to get data on several cryptocurrencies
        $response = $this->client->get('data/pricemultifull', [
            'query' => [
                'fsyms' => implode(',', $this->api_ids), // Cryptocurrencies to get data of
                'tsyms' => $this->conversion_currency // Real currency for conversion
            ]
        ]);

        $this->data = json_decode($response->getBody())->RAW; // Get data from JSON

        // Loop through currencies to add data from API
        $currencies = $currencies->map(function ($currency) {
            $conversion_currency = $this->conversion_currency;
            $api_id = $currency['currency']->api_id;

            $currency['current_rate'] = $this->data->$api_id->$conversion_currency->PRICE;
            $currency['change'] = $this->data->$api_id->$conversion_currency->CHANGE24HOUR > 0 ? '+' : '-';
            $currency['increase'] = round($currency['current_rate'] * $currency['total_quantity'] - $currency['total_amount'], 2); // Compare what the user spent to what they could get if they sold it all to calculate increase/decrease

            return $currency;
        });

        return view('wallet.index', ['currencies' => $currencies]);
    }
}
