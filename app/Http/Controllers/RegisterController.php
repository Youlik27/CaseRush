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

    public function validate(Request $request)
    {
        // Валидация данных формы
        return $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    public function process(Request $request)
    {
        $this->validate($request);
        $username= $request->input('username');
        $email= $request->input('email');
        $username_exists = User::where('username', $username)->exists();
        $email_exists = User::where('email', $email)->exists();
        $user = $this->getInfo($username, $email);
        $password = $request->input('password');
        if ($email_exists) {
            return redirect()->route('register');
        }
        if ($username_exists) {
            return redirect()->route('register');
        }
        $this->createUser([
            'username' => $username,
            'email' => $email,
            'password' => $password
        ]);

        return redirect()->route('login')->with('success', 'Rejestracja zakończona sukcesem! Zaloguj się.');
    }
    private function createUser(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'balance' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $maxId = User::max('id_user');
        $user->created_by = $maxId;
        $user->updated_by = $maxId;

        // Сохраняем изменения
        $user->save();
    }

}
