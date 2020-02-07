<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display the currencies list with their current rate.
     */
    public function index()
    {
        return view('currencies.index');
    }

    /**
     * Display a currency's rate history.
     */
    public function show($id)
    {
        //
    }
}
