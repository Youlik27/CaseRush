<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function getInfo($username, $email){
        return User::where('username', '=', $username)->orWhere('email', '=', $email)->first();
    }
    public function generateView(){
        return view('register');
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'balance' => 0,
            ]);

            return redirect()->route('login')->with('success', 'Rejestracja zakończona sukcesem!');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Wystąpił błąd podczas rejestracji.');
        }
    }


}
