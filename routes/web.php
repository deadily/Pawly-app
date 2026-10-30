<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\TagController;

// Ресурсные маршруты автоматически создадут:
// GET /pets, GET /pets/create, POST /pets, GET /pets/{pet}, и т.д.
Route::resource('pets', PetController::class);
Route::resource('articles', ArticleController::class);

// Для справочников часто достаточно только просмотра
Route::get('/types', [TypeController::class, 'index'])->name('types.index');
Route::get('/tags', [TagController::class, 'index'])->name('tags.index');



use Illuminate\Support\Facades\Auth; // <-- Добавляем этот импорт
use App\Http\Controllers\AuthController;

// Главная страница
Route::get('/', function () {
    return view('index');
})->name('home');

// Маршруты для модалок (обработка форм)
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Страница после входа (дашборд)
Route::get('/dashboard', function () {
    // Используем Auth::user() вместо auth()->user()
    $userName = Auth::user()->name; 
    
    return "Добро пожаловать, {$userName}! <a href='/logout'>Выйти</a>";
})->middleware('auth')->name('dashboard');

// Выход из системы
Route::get('/logout', function () {
    // Используем Auth::logout() вместо auth()->logout()
    Auth::logout(); 
    return redirect('/');
})->name('logout');


use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');