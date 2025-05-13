<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function generateView(Request $request)
    {
        $search = $request->get('search', '');

        $users = User::where('username', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->paginate(10);
        return view('user-management', compact('users', 'search'));

    }


    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email',
            'balance' => 'required|numeric'
        ]);

        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->balance = $validated['balance'];
        $user->save();

        return response()->json(['success' => true]);
    }
}
