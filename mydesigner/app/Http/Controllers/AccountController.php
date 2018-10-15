<?php

namespace MyDesigner\Http\Controllers;

use MyDesigner\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin|designer|user');
    }

    /**
     * Display the specified resource.
     *
     * @param  \MyDesigner\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {   
        $user = Auth::user();
        return view('account', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \MyDesigner\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $user = Auth::user();
        return view('edit-account', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        if(Auth::user()->email != request('email')) {

            $validator = $request->validate([
                'email' => 'required|email|max:255|unique:users'
            ]);

            $user->email = request('email');
        }

        if( ! empty(request('password')) ) {

            $validator = $request->validate([
                'password'     => 'min:8|confirmed',
            ]);

            $user->password = Hash::make(request('password'));
        }

        $validator = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255'
        ]);

        $user->first_name = request('first_name');
        $user->last_name = request('last_name');

        $user->save();

        return redirect()->back()->with('success', 'Account updated.');

    }

}
