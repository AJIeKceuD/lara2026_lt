@extends('layouts.app')

@section('title', __('Posts'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('Posts') }}</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                @if($post->preview_image)
                    <img src="{{ Storage::url($post->preview_image) }}" 
                         alt="{{ $post->title }}" 
                         class="w-full h-48 object-cover">
                @endif
                
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">
                        <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" 
                           class="hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h2>
                    
                    <div class="flex items-center text-sm text-gray-600 mb-3">
                        <span>{{ $post->published_at->format('d.m.Y') }}</span>
                        @if($post->reading_time)
                            <span class="mx-2">•</span>
                            <span>{{ $post->reading_time }} мин чтения</span>
                        @endif
                    </div>
                    
                    <p class="text-gray-700 mb-4">
                        {{ Str::limit(strip_tags($post->content), 150) }}
                    </p>
                    
                    <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" 
                       class="text-blue-600 hover:underline">
                        {{ __('Читать далее') }} →
                    </a>
                </div>
            </article>
        @empty
            <p class="text-gray-500">{{ __('Новостей пока нет') }}</p>
        @endforelse
    </div>
    
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection