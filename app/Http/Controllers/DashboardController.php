<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Проверяем, есть ли у пользователя питомцы
        $hasPets = $user->pets()->exists();
        
        return view('dashboard', compact('user', 'hasPets'));
    }
}