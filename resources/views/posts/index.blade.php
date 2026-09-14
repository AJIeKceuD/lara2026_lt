@extends('layouts.app')

@section('title', __('Posts'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">{{ __('Posts') }}</h1>

        @forelse($posts as $post)
            <div>
                <h3 class="">{{ $post->title }}</h3>
            </div>
            <div class="grid @if($post->preview_image) grid-cols-4 @else grid-cols-1 @endif gap-6">
                <div class="py-4 px-3 col-span-3">
                    <p class="text-sm">{!! truncateHtml($post->content, 800) !!}</p>
                    <div class="text-sm font-bold my-6">{{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}</div>
                    <div class="">
                        <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="black_btn">
                            {{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="arrow-in-line">→</span>
                        </a>
                    </div>
                </div>
                @if($post->preview_image)
                    <div class="py-4 col-span-1">
                        <img src="{{ Storage::url($post->preview_image) }}"
                            alt="{{ $post->title }}"
                            class="w-full h-48 object-cover">
                    </div>
                @endif
            </div>
            <div>
                <hr />
                &nbsp;
            </div>
        @empty
            <p class="text-gray-500">{{ __('') }}</p>
        @endforelse

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection