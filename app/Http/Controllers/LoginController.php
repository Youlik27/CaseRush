<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function getInfo($usernameAndEmail){
        return User::where('username', '=', $usernameAndEmail)->orWhere('email', '=', $usernameAndEmail)->first();
    }


    public function validate(Request $request)
    {
        return $request->validate([
            'usernameAndEmail' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function process(Request $request)
    {
        $this->validate($request);
        $usernameAndEmail = $request->input('usernameAndEmail');
        $user = $this->getInfo($usernameAndEmail);
        $password = $request->input('password');
        if ($user === null) {
            return redirect()->route('login')->withErrors(['error' => 'Nieprawidłowa nazwa użytkownika lub email.']);
        }
        if (!(hash::check($password,$user->password))) {
            return redirect()->route('login')->withErrors(['error' => 'Nieprawidłowe hasło']);
        }
        if(($usernameAndEmail == $user->username|| $usernameAndEmail == $user->email) && hash::check($password, $user->password)){
            Auth::login($user);
            return redirect()->route('case_content');
        }
        else return redirect()->route('login');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
