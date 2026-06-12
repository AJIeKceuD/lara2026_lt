<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\TopImage;

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

        // Получаем верхние картинки
        $topImages = TopImage::published()
            ->forLocale($locale)
            ->get();
            // dd($topImages);
        
        return view('home', compact('locale', 'latestPosts', 'topImages'));
    }
}
