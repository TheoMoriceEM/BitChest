<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\API;

class CalculateBalance
{
    protected $api_ids;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_ids = []; // Init an array for currencies' API IDs (for the API call)
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api = new API;

        $currencies = Auth::user()
            ->transactions // Get user's transactions
            ->where('sold', 0) // Unsold
            ->groupBy('currency_id') // Group them by currency
            ->map(function ($row) {
                    $this->api_ids[] = $row->first()->currency->api_id; // Fill API IDs array for future API call
                    return [
                        'currency' => $row->first()->currency,
                        'quantity' => $row->sum('quantity') // Calculate the total of this currency
                    ];
                });

        if ($currencies->isNotEmpty()) {
            $this->data = $api->getMultipleData(implode(',', $this->api_ids)); // Get data from the API
        }

        // Loop through currencies to add data from API
        $currencies = $currencies->map(function ($currency) {
            $api_id = $currency['currency']->api_id;
            $currency['current_rate'] = $this->data[$api_id]['current_rate'];
            return $currency;
        });

        $balance = 0;

        foreach ($currencies as $currency) {
            $balance += $currency['quantity'] * $currency['current_rate'];
        }

        session(['balance' => round($balance, 2)]);

        return $next($request);
    }
}
