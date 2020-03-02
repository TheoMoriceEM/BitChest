<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display all of the user's transactions.
     */
    public function indexByUser($id)
    {
        //
    }

    /**
     * Display the user's transactions corresponding to a currency.
     */
    public function indexByCurrency($user_id, $currency_id)
    {
        //
    }

    /**
     * Display the user's transactions corresponding to a currency in order to sell them.
     */
    public function indexForSell($user_id, $currency_id)
    {
        //
    }

    /**
     * Show the form for buying a currency.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($currency)
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
