<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    // GET /pets - Список всех питомцев
    public function index()
    {
        // Загружаем питомцев вместе с их типом и фото (чтобы не было N+1 запросов)
        $pets = Pet::with(['type', 'photos'])->latest()->paginate(12);
        
        // Передаем данные в blade-шаблон resources/views/pets/index.blade.php
        return view('pets.index', compact('pets'));
    }

    // GET /pets/create - Форма создания питомца
    public function create()
    {
        // Нам нужны типы питомцев для выпадающего списка в форме
        $types = Type::all();
        return view('pets.create', compact('types'));
    }

    // POST /pets - Сохранение нового питомца
    public function store(Request $request)
    {
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'date_of_birth' => 'required|date',
            'pet_avatar_url' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Обработка загрузки аватара (если есть)
        if ($request->hasFile('pet_avatar_url')) {
            $path = $request->file('pet_avatar_url')->store('pets/avatars', 'public');
            $validated['pet_avatar_url'] = '/storage/' . $path;
        }

        // Создание записи в БД
        $pet = Pet::create($validated);

        // Привязка питомца к текущему пользователю (если авторизован)
        if (Auth::check()) {
            \App\Models\User::find(Auth::id())->pets()->attach($pet->id);
        }

        return redirect()->route('pets.index')
                         ->with('success', 'Питомец успешно добавлен!');
    }

    // GET /pets/{pet} - Просмотр одного питомца
    public function show(Pet $pet)
    {
        // Автоматически подгружаем связи
        $pet->load(['type', 'photos', 'things']);
        return view('pets.show', compact('pet'));
    }
}