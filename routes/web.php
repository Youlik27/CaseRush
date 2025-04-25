<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'getInfo']);
Route::get('/case_content', [MainController::class, 'getInfo'])->name('case_content');
Route::get('/login', function (){
    return view('login');
})->name('login');

Route::post('/login/process', [LoginController::class, 'process'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'generateView'])->name('register');
Route::post('/register/process', [RegisterController::class, 'process'])->name('register.process');


Route::get('/profile', [ProfileController::class, 'generateView'])->name('profile');
Route::post('/profile/edit', [ProfileController::class, 'process'])->name('profile.edit');

//Route::get('/users_management', [AdminController::class, 'updateUser'])->name('users.management');

Route::get('/users_management', function (){
    return view('user-management');
})->name('users.management');


Route::get('/lo1', [LoginController::class, 'generateView']);
