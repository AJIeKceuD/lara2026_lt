@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="container mx-auto px-4 py-8">
    <header class="mb-8">
        <h1>{{ $post->title }}</h1>
        
        <div class="flex items-center text-gray-600 mb-6">
            <span>{{ $post->published_at->isoFormat('D MMMM YYYY') }}</span>
            @if($post->reading_time)
                <span>• {{ $post->reading_time }} {{ __('MIN READ') }}</span>
            @endif
        </div>
    </header>
    
    <div class="prose prose-lg max-w-none">
        {!! $post->content !!}
    </div>
    
    <div class="mt-8">
        <a href="{{ route('posts.index', app()->getLocale()) }}" class="black_btn">
            {{ __('Back to posts') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="arrow-in-line">→</span>
        </a>
    </div>
</article>
@endsection