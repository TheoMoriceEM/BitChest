<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Currency;
use App\Transaction;
use App\User;
use App\API;

class TransactionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if (Str::contains($request->path(), 'create')) {
            view()->composer('layouts.layout', function ($view) {
                $view->with('section', 'currencies');
            });
        } else {
            view()->composer('layouts.layout', function ($view) {
                $view->with('section', 'wallet');
            });
        }

        date_default_timezone_set('Europe/Paris'); // Set timezone
    }

    /**
     * Display the user's transactions (all of them or by currency).
     */
    public function index(Currency $currency = null)
    {
        $transactions = $currency // If a currency is specified :
            ? Auth::user()->transactions()->where('currency_id', $currency->id)->get() // Get the uder's transactions corresponding to this currency
            : Auth::user()->transactions; // Else, get all of their transactions

        // Format a few fields of the transactions
        $transactions = $transactions->map(function ($transaction) {
            // Round figures to make them more readable
            $transaction->quantity = round($transaction->quantity, 4);

            $transaction->purchase_price = round($transaction->purchase_price, 4);

            $transaction->selling_price = round($transaction->selling_price, 4);

            return $transaction;
        });

        return view('transactions.index', ['transactions' => $transactions, 'currency' => $currency]);
    }

    /**
     * Display the user's transactions corresponding to a currency in order to sell them.
     */
    public function sell(Currency $currency)
    {
        $transactions = Auth::user() // Logged in user
            ->transactions() // Get his transactions
            ->where([ // Filter by :
                'sold' => false, // Unsold ones
                'currency_id' => $currency->id // Corresponding to the specified currency
            ])
            ->get();

        // Format a few fields of the transactions
        $transactions = $transactions->map(function ($transaction) {
            $transaction->purchase_price = round($transaction->purchase_price, 4); // Round figures to make them more readable
            return $transaction;
        });

        $title = 'Vente de ' . $currency->name;

        return view('transactions.sell', ['transactions' => $transactions, 'title' => $title]);
    }

    /**
     * Show the form for buying a currency.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Currency $currency)
    {
        $title = 'Acheter du ' . $currency->name;

        return view('transactions.create', ['title' => $title, 'currency' => $currency]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, API $api)
    {
        $attributes = $request->all(); // Get form inputs data

        $attributes['user_id'] = Auth::id(); // Get user's id to insert it
        $attributes['purchase_date'] = Carbon::now()->toDateTimeString(); // Get current datetime to insert it
        $attributes['purchase_price'] = $api->getPrice($attributes['currency_api_id']); // Get current rate to insert it

        // Calculate quantity or amount depending on which buying option the user chose
        if ($attributes['buying_option'] == 'amountBuyingInput') {
            $attributes['quantity'] = $attributes['amount'] / $attributes['purchase_price'];
        } elseif ($attributes['buying_option'] == 'quantityBuyingInput') {
            $attributes['amount'] = $attributes['quantity'] * $attributes['purchase_price'];
        }

        $transaction = Transaction::create($attributes); // Create transaction in DB

        return redirect()
            ->route('wallet')
            ->with('message', 'La transaction a bien été effectuée. Vous avez acheté : ' . round($transaction->quantity, 6) . ' ' . $transaction->currency->name . ' pour un montant de ' . $transaction->amount . ' ' . config('currency')['symbol'] . '.');
    }

    /**
     * Sell one specified transaction or all those of a currency.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Currency $currency, Transaction $transaction = null, Request $request, API $api)
    {
        if ($transaction) {
            $transaction->sold = 1;
            $transaction->selling_amount = round($request->selling_amount, 2);
            $transaction->selling_price = $request->selling_price;
            $transaction->selling_date = Carbon::now();

            $transaction->save();

            return redirect()
                ->route('wallet')
                ->with('message', 'La transaction a bien été effectuée. Vous avez vendu : ' . floatval($transaction->quantity) . ' ' . $currency->name . ' pour un montant de ' . round($request->selling_amount, 2) . ' ' . config('currency')['symbol'] . '.');
        } else {
            $quantity_total = 0;
            $selling_amount_total = 0;

            $transactions = Transaction::where([
                'currency_id' => $currency->id,
                'user_id' => Auth::id()
            ]);

            $transactions->update([
                'sold' => 1,
                'selling_price' => $api->getPrice($currency->api_id),
                'selling_date' => Carbon::now()
            ]);

            foreach ($transactions->get() as $transaction) {
                $transaction->selling_amount = $transaction->selling_price * $transaction->quantity;
                $transaction->save();

                $quantity_total += $transaction->quantity;
                $selling_amount_total += $transaction->selling_amount;
            }

            return redirect()
                ->route('wallet')
                ->with('message', 'La transaction a bien été effectuée. Vous avez vendu : ' . floatval($quantity_total) . ' ' . $currency->name . ' pour un montant de ' . round($selling_amount_total, 2) . ' ' . config('currency')['symbol'] . '.');
        }
    }
}
