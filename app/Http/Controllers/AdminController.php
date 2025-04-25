<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Метод для отображения страницы с пользователями
    public function index()
    {
        $users = User::all();  // Получаем всех пользователей
        return view('users.index', compact('users'));
    }

    // Метод для обновления данных пользователя
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        // Валидируем данные
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'role' => 'required|string|in:admin,user',
        ]);

        // Обновляем данные пользователя
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        return response()->json(['message' => 'Данные обновлены']);
    }
}
