<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function PHPUnit\Framework\isNull;

class ProfileController extends Controller
{
    public function getInfo(){
        return auth()->user();
    }
    public function generateView(){
        return view('profile');
    }

    public function validate(Request $request)
    {
        return $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|string|email|unique:users,email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
    private function avatarUpload(Request $request, $user)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');

            $filename = $user->id_user . '.' . $file->getClientOriginalExtension();

            $file->storeAs('images/users_avatars', $filename);

            $user->image_url = 'storage/images/users_avatars/' . $filename;
        }
    }
    public function process(Request $request)
    {
        $user = $this->getInfo();
        $this->avatarUpload($request, $user);

        $username= $request->input('username');
        $email= $request->input('email');
        $steam_id = $request->input('steam_id');

        $steam_id_exists =User::where('steam_id', $steam_id)->where('id_user', '!=', $user->id_user)->exists();
        $username_exists = User::where('username', $username)->where('id_user', '!=', $user->id_user)->exists();
        $email_exists = User::where('email', $email)->where('id_user', '!=', $user->id_user)->exists();
        if (is_null($email)) {
            return redirect()->route('profile')->withErrors(['error' => 'Email nie może być pusty']);
        }
        if ($email_exists) {
            $this->validate($request);
            return redirect()->route('profile');
        }
        if (is_null($username)) {
            return redirect()->route('profile')->withErrors(['error' => 'Nazwa użytkownika nie może być pusta']);
        }
        if ($username_exists) {
            $this->validate($request);
            return redirect()->route('profile');
        }
        if (is_null($steam_id)) {
            return redirect()->route('profile')->withErrors(['error' => 'Steam id nie może być pusty']);
        }
        if ($steam_id_exists) {

            return redirect()->route('profile')->withErrors(['error' => 'Ten Steam ID jest już używany przez innego użytkownika']);
       }
        $this->updateUser($user, $username, $steam_id, $email);
        return redirect()->route('profile');
    }
    private function updateUser($user, $username, $steam_id, $email)
    {
        $user->username = $username;
        $user->steam_id = $steam_id;
        $user->email = $email;
        $user->save();
    }
}
