<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with(['author', 'tag'])
                           ->latest()
                           ->paginate(10);
                           
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('articles.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tag_id' => 'nullable|exists:tags,id',
            'banner_photo_url' => 'nullable|url',
        ]);

        // Автоматически ставим автора - текущего пользователя
        $validated['user_id'] = Auth::id();

        Article::create($validated);

        return redirect()->route('articles.index')
                         ->with('success', 'Статья опубликована!');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }
}