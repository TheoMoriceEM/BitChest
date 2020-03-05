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

        $this->conversion_currency = config('currency')['api_id'];

        $this->api_ids = [];
    }

    /**
     * Display the user's wallet.
     */
    public function index()
    {
        $user = User::find(Auth::id());

        $currencies = $user
            ->transactions
            ->where('sold', 0)
            ->groupBy('currency_id')
            ->map(function ($row) {
                    $this->api_ids[] = $row->first()->currency->api_id;
                    return [
                        'currency'          => $row->first()->currency,
                        'total_quantity'    => $row->sum('quantity'),
                        'total_amount'      => $row->sum('amount')
                    ];
                });

        $response = $this->client->get('data/pricemultifull', [
            'query' => [
                'fsyms' => implode(',', $this->api_ids),
                'tsyms' => $this->conversion_currency
            ]
        ]);

        $this->data = json_decode($response->getBody())->RAW;

        $currencies = $currencies->map(function ($currency) {
            $conversion_currency = $this->conversion_currency;
            $api_id = $currency['currency']->api_id;

            $currency['current_rate'] = $this->data->$api_id->$conversion_currency->PRICE;
            $currency['change'] = $this->data->$api_id->$conversion_currency->CHANGE24HOUR > 0 ? '+' : '-';
            $currency['increase'] = $currency['current_rate'] * $currency['total_quantity'] - $currency['total_amount'];

            return $currency;
        });

        return view('wallet.index', ['currencies' => $currencies]);
    }
}
