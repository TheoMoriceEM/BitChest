<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\API;

class WalletController extends Controller
{
    protected $data;
    protected $api_ids;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        view()->composer('layouts.layout', function ($view) {
            $view->with('section', 'wallet');
        });

        $this->api_ids = []; // Init an array for currencies' API IDs (for the API call)
    }

    /**
     * Display the user's wallet.
     */
    public function index(API $api)
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

        if ($currencies->isNotEmpty()) {
            $this->data = $api->getMultipleData(implode(',', $this->api_ids)); // Get data from the API

            // Loop through currencies to add data from API
            $currencies = $currencies->map(function ($currency) {
                $api_id = $currency['currency']->api_id;

                $currency['current_rate'] = $this->data[$api_id]['current_rate'];
                $currency['change'] = $this->data[$api_id]['change'];
                $currency['increase'] = round($currency['current_rate'] * $currency['total_quantity'] - $currency['total_amount'], 2); // Compare what the user spent to what they could get if they sold it all to calculate increase/decrease

                return $currency;
            });
        }

        return view('wallet.index', ['currencies' => $currencies]);
    }
}
