@extends('layouts.app')

@section('title', $post->title)

@section('content')
<article class="post-object container mx-auto px-4 mt-[128px] max-sm:mt-[71px] mb-[200px]">
    @php $locale = app()->getLocale(); @endphp

    <h1>
        {{ $post->title }}
    </h1>

    @if($post->getTranslation('main_image_alt', $locale, false))
        <div class="main-image-alt">
            {{ $post->getTranslation('main_image_alt', $locale) }}
        </div>
    @endif

    @if($post->main_image)
        <div class="main-image w-full mb-20 max-sm:mb-[24px]">
            <img
                src="{{ Storage::url($post->main_image) }}"
                alt="{{ $post->getTranslation('main_image_alt', $locale, false) ?? $post->title }}"
                class="w-full h-auto object-cover rounded-t-[104px]"
                loading="lazy"
            >
        </div>
    @endif

    <div class="grid grid-cols-2 max-lg:grid-cols-1">
        <div class="post-content max-lg:order-2 max-lg:col-span-2">
            {!! $post->content !!}
        </div>

        <aside class="published-at max-lg:order-1 max-lg:col-span-2 ml-[50%] max-lg:ml-[0%]">
            <hr>
            <div>
                {{ $post->published_at?->isoFormat('D MMMM YYYY') }}
            </div>
        </aside>
    </div>
</article>
@endsection