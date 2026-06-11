<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    // Список всех опубликованных постов
    public function index(Request $request, $locale)
    {
        // dd($locale);
        // $locale = app()->getLocale();
        app()->setLocale($locale);
        
        $posts = Post::published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);
        
        return view('posts.index', compact('posts'));
    }
    
    // Просмотр одного поста
    public function show(Request $request, $locale, $slug)
    {
        $post = Post::published()
            ->where("slug->{$locale}", $slug)
            ->firstOrFail();
        
        return view('posts.show', compact('post'));
    }
}
