@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="container mx-auto px-4 py-8 max-w-4xl">
    <header class="mb-8">
        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
        
        <div class="flex items-center text-gray-600 mb-6">
            <span>{{ $post->published_at->format('d.m.Y') }}</span>
            @if($post->reading_time)
                <span class="mx-2">•</span>
                <span>{{ $post->reading_time }} мин чтения</span>
            @endif
        </div>
        
        @if($post->preview_image)
            <img src="{{ Storage::url($post->preview_image) }}" 
                 alt="{{ $post->title }}" 
                 class="w-full rounded-lg shadow-md">
        @endif
    </header>
    
    <div class="prose prose-lg max-w-none">
        {!! $post->content !!}
    </div>
    
    <div class="mt-8 pt-4 border-t">
        <a href="{{ route('posts.index', app()->getLocale()) }}" 
           class="text-blue-600 hover:underline">
            ← {{ __('Назад к новостям') }}
        </a>
    </div>
</article>
@endsection