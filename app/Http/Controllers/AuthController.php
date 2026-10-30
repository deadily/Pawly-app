<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Константы для ролей (удобно использовать в коде вместо магических чисел)
    const ROLE_ADMIN = 1;
    const ROLE_USER = 2;

    // Обработка входа
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ищем пользователя по email или имени
        $user = User::where('email', $credentials['email'])
                    ->orWhere('name', $credentials['email'])
                    ->first();

        if ($user && Hash::check($credentials['password'], $user->password_hash)) {
            Auth::login($user);
            
            // Редирект в зависимости от роли
            if ($user->role_id === self::ROLE_ADMIN) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors(['email' => 'Неверные учетные данные'])
            ->withInput();
    }

    // Обработка регистрации
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'agree_rules' => 'required|accepted',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password_hash' => Hash::make($validated['password']),
            // ВСЕГДА присваиваем роль "Пользователь" (ID=2) при регистрации
            'role_id' => self::ROLE_USER, 
        ]);

        Auth::login($user);
        
        // Если выбрал "Есть питомец" - редирект на форму добавления
        if ($request->has('has_pet')) {
        return redirect()->route('pets.create'); // Форма добавления питомца
    }

    return redirect()->route('dashboard'); // Страница без питомца
    }
}