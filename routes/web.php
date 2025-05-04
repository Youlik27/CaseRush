<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

// Strona główna
Route::get('/', [MainController::class, 'generateView']);

// Strona z treścią case'a
Route::get('/case_content', [MainController::class, 'generateView'])->name('case_content');

// Logowanie
Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login/process', [LoginController::class, 'process'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Rejestracja
Route::get('/register', [RegisterController::class, 'generateView'])->name('register');
Route::post('/register/process', [RegisterController::class, 'process'])->name('register.process');

// Profil – tylko dla zalogowanych z rolą
Route::get('/profile', function () {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return view('profile');
    }
    abort(403, 'Dostęp zabroniony');
})->name('profile');

Route::post('/profile/edit', function () {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return app(ProfileController::class)->process(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('profile.edit');

// Zarządzanie użytkownikami – tylko dla admina
Route::get('/users_management', function () {
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return view('user-management');
    }
    abort(403, 'Dostęp zabroniony');
})->name('users.management');

// Dodanie sekcji – tylko dla moderatora
Route::post('/moderating_add_section', function () {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->createSection(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.add.section');

// Zmiana nazwy sekcji – tylko dla moderatora
Route::post('/moderating_change_section_name', function () {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->changeName(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.change.section.name');

// Usunięcie sekcji – tylko dla moderatora
Route::delete('/moderating_delate_section_{section_id}', function ($section_id) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->deleteSection($section_id);
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.delete.section');

// Przeniesienie sekcji w górę – tylko dla moderatora
Route::post('/moderating_move_up_section_{section_id}', function ($section_id) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->moveUpSection($section_id);
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.move.up.section');

// Przeniesienie sekcji w dół – tylko dla moderatora
Route::post('/moderating_move_down_section_{section_id}', function ($section_id) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->moveDownSection($section_id);
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.move.down.section');

// Tworzenie case’a – tylko dla moderatora
Route::post('/case_creation', function () {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->generateViewCaseCreating(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.creating');

// Aktualizacja case’a – tylko dla moderatora
Route::post('/case_updating', function () {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->caseUpdating(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.updating');

// Strona potwierdzająca utworzenie case’a – tylko dla moderatora
