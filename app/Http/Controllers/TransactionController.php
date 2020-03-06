<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function __construct()
    {
        date_default_timezone_set('Europe/Paris'); // Set timezone
    }

    /**
     * Display the user's transactions (all of them or by currency).
     */
    public function index(Currency $currency = null)
    {
        $user = User::find(Auth::id());
        $transactions = $currency
            ? $user->transactions()->where('currency_id', $currency->id)->get()
            : $user->transactions;

        $transactions = $transactions->map(function ($transaction) {
            $carbon_purchase_date = new Carbon($transaction->purchase_date);
            $transaction->purchase_date = $carbon_purchase_date->format('d/m/Y h:m');

            $carbon_selling_date = new Carbon($transaction->selling_date);
            $transaction->selling_date = $carbon_selling_date->format('d/m/Y h:m');

            return $transaction;
        });

        return view('transactions.index', ['transactions' => $transactions, 'currency' => $currency]);
    }

    /**
     * Display the user's transactions corresponding to a currency in order to sell them.
     */
    public function indexForSell(Currency $currency)
    {
        $transactions = User::find(Auth::id())
            ->transactions()
            ->where([
                'sold' => false,
                'currency_id' => $currency->id
            ])
            ->get();

        $transactions = $transactions->map(function ($transaction) {
            $carbon_purchase_date = new Carbon($transaction->purchase_date);
            $transaction->purchase_date = $carbon_purchase_date->format('d/m/Y h:m');
            return $transaction;
        });

        return view('transactions.indexForSell', ['transactions' => $transactions]);
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

        // TODO: send back to wallet homepage
        return redirect()->route('home');
        // return redirect()
        //     ->route('...')
        //     ->with('message', 'La transaction a bien été effectuée. Vous avez acheté : ' . $transaction->quantity . ' ' . $transaction->currency->name . '.');
    }

    /**
     * Sell a currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Sell all the user's stock of a currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request, $currency_id)
    {
        //
    }
}
