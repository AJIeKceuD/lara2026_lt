<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index(Request $request, $locale)
    {
        // Устанавливаем язык
        app()->setLocale($locale);
        
        // Получаем последние 3 поста для главной
        $latestPosts = Post::published()
            ->orderBy('published_at', 'desc')
            ->limit(3)
            ->get();
        
        return view('home', compact('latestPosts'));
    }
}
