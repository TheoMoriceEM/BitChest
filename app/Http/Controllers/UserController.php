<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;
use App\Transaction;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        if (Str::contains($request->path(), 'my-account')) {
            view()->composer('layouts.layout', function ($view) {
                $view->with('section', 'account');
            });
        } else {
            view()->composer('layouts.layout', function ($view) {
                $view->with('section', 'users');
            });
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all()->except(Auth::id()); // Get all users except the logged one

        // Format subscription date
        $users = $users->map(function ($user) {
            $carbon_date = new Carbon($user->created_at);
            $user->subscription_date = $carbon_date->format('d/m/Y h:m');
            return $user;
        });

        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email'     => 'unique:App\User,email', // Check if email hasn't already been taken
            'password'  => 'confirmed' // Check if password is correctly confirmed
        ]);

        $attributes = $request->all();
        $attributes['password'] = Hash::make($request->password); // Hash password

        User::create($attributes); // Create the user in DB

        return redirect()
            ->route('users.index')
            ->with('message', "L'utilisateur a bien été créé.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Show the form for editing the logged user's account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMyAccount()
    {
        return view('users.my-account', ['user' => Auth::user()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'email' => 'unique:App\User,email,' . $user->id . ',id' // Check if email hasn't already been taken (except by this user)
        ]);

        $user->update($request->all()); // Update the user in DB

        return redirect()
            ->route('users.index')
            ->with('message', "L'utilisateur a bien été modifié.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateMyAccount(Request $request, User $user)
    {
        $request->validate([
            'email' => 'unique:App\User,email,' . $user->id . ',id' // Check if email hasn't already been taken (except by this user)
        ]);

        $user->update($request->all()); // Update the user in DB

        return redirect()
            ->route('home')
            ->with('message', "Vos informations personnelles ont bien été modifiées.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Transaction::where('user_id', $user->id)->delete(); // Delete user's transactions

        $user->delete(); // Delete user

        return redirect()
            ->route('users.index')
            ->with('message', "L'utilisateur a bien été supprimé.");
    }
}
