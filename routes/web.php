<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CaseOpeningController;
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
        return app(ProfileController::class)->generateView();
    }
    abort(403, 'Dostęp zabroniony');
})->name('profile');
Route::post('/profile/sell-item-{id_drop}', function ($id_drop) {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return app(ProfileController::class)->sellItem($id_drop);
    }
    abort(403, 'Dostęp zabroniony');
})->name('profile.item.sell');
Route::post('/profile/edit', function () {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return app(ProfileController::class)->process(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('profile.edit');

// Zarządzanie użytkownikami – tylko dla admina
Route::get('/users_management', function () {
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return app(AdminController::class)->generateView(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('users.management');
Route::post('/update-user/{userId}', function ($userId) {
    if (auth()->check() && auth()->user()->hasRole('admin')) {
        return app(AdminController::class)->updateUser(request(),$userId);
    }
    abort(403, 'Dostęp zabroniony');
})->name('update.user');
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
Route::delete('/moderating_delete_section_{section_id}', function ($section_id) {
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
Route::delete('/moderating_delete_case_{case_id}', function ($case) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->deleteCase($case);
    }
    abort(403, 'Dostęp zabroniony');
})->name('moderating.delete.case');

// Tworzenie case’a – tylko dla moderatora
Route::post('/case_creation', function () {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->createCase(request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.creating');

Route::post('/case_updating_enter-{id_case}', function ($id_case) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->generateViewCaseUpdating($id_case);
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.updating.enter');
// Aktualizacja case’a – tylko dla moderatora
Route::post('/case_updating-{id_case}', function ($id_case) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->caseUpdating($id_case, request());
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.updating');
Route::post('/item_created-{id_case}', function ($id_case) {
    if (auth()->check() && auth()->user()->hasRole('moderator')) {
        return app(ModeratorController::class)->itemCreating(request(), $id_case);
    }
    abort(403, 'Dostęp zabroniony');
})->name('item.creating');
Route::get('/case-opening-{id_case}', function ($id_case) {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return app(CaseOpeningController::class)->generateView($id_case);
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.opening');
Route::get('/case-{id_case}', function ($id_case) {
    if (auth()->check() && auth()->user()->hasRole(['moderator', 'admin', 'user'])) {
        return app(CaseOpeningController::class)->show($id_case);
    }
    abort(403, 'Dostęp zabroniony');
})->name('case.show');
Route::POST('/case_opened-{id_case}', [CaseOpeningController::class, 'open'])
    ->name('case.open');

// Strona potwierdzająca utworzenie case’a – tylko dla moderatora
