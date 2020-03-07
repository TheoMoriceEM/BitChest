<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
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
    public function edit($id)
    {
        //
    }

    /**
     * Show the form for editing the logged user's account.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editMyAccount($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
