@extends('layouts.app')

@section('title', __('Home'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <section class="grid grid-cols-2 gap-4">
        @if($topImages->count() > 0)
            <div 
                x-data="{
                    currentIndex: 0,
                    total: Number({{ $topImages->count() }}),
                    interval: null,
                    autoplayDelay: 3000,
                    init() {
                        console.log('total:', this.total, 'type:', typeof this.total);
                        if (this.total > 1) this.startAutoplay()
                    },
                    startAutoplay() {
                        this.interval = setInterval(() => this.next(), this.autoplayDelay)
                    },
                    stopAutoplay() { 
                        if (this.interval) clearInterval(this.interval) 
                    },
                    next() { 
                        this.currentIndex = (this.currentIndex + 1) % this.total 
                    },
                    previous() { 
                        this.currentIndex = (this.currentIndex - 1 + this.total) % this.total 
                    },
                    goTo(index) { 
                        this.currentIndex = index 
                    }
                }"
                @mouseenter="total > 1 && stopAutoplay()"
                @mouseleave="total > 1 && startAutoplay()"
                class="relative w-[400px] h-[400px] mx-auto"
            >
                <div class="relative w-full h-full overflow-hidden rounded-lg">
                    @foreach($topImages as $index => $image)
                        <div 
                            x-show="currentIndex === {{ $index }}"
                            class="w-full h-full"
                        >
                            <img 
                                src="{{ Storage::url($image->image_path) }}" 
                                alt="{{ $image->getTranslation('alt_text', $locale, false) ?? '' }}"
                                class="w-full h-full object-cover"
                                loading="lazy"
                            >
                        </div>
                    @endforeach
                </div>

                @if($topImages->count() > 1)
                    <!--button @click="previous()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10">◀</button>
                    <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10">▶</button-->
                    
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-10">
                        <template x-for="index in total" :key="index">
                            <button 
                                @click="goTo(index - 1)"
                                class="rounded-full transition-all duration-300"
                                :class="{
                                    'bg-white w-1.5 h-4': currentIndex === (index - 1),
                                    'bg-gray-400 w-1.5 h-1.5': currentIndex !== (index - 1)
                                }"
                            ></button>
                        </template>
                    </div>
                @endif
            </div>
        @endif

        <!--div class="mr-auto justify-start">
        @if($topImages->count() && false)
            <div 
                x-data="{
                    images: @js($topImages->map(fn($img) => Storage::url($img->image_path))->toArray()),
                    alts: @js($topImages->map(fn($img) => $img->getTranslation('alt_text', $locale, false) ?? '')->toArray()),
                    currentIndex: 0,
                    interval: null,
                    init() {
                        this.startAutoplay()
                    },
                    startAutoplay() {
                        this.interval = setInterval(() => {
                            this.currentIndex = (this.currentIndex + 1) % this.images.length
                        }, 3000)
                    },
                    stopAutoplay() {
                        clearInterval(this.interval)
                    },
                    next() {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length
                    },
                    previous() {
                        this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length
                    },
                    goTo(index) {
                        this.currentIndex = index
                    }
                }"
                @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()"
                class="relative w-[400px] h-[400px] mx-auto"
            >
                <img 
                    :src="images[currentIndex]"
                    :alt="alts[currentIndex]"
                    class="w-full h-full object-cover rounded-lg"
                >
                
                <div class="absolute left-4 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-10">
                    <template x-for="(image, index) in images" :key="index">
                        <button 
                            @click="goTo(index)"
                            class="rounded-full transition-all duration-300"
                            :class="{
                                'bg-white w-1.5 h-4': currentIndex === index,
                                '!bg-gray-400 w-1.5 h-1.5': currentIndex !== index
                            }"
                        ></button>
                    </template>
                </div>
            </div>
        @endif
        </div-->
        <div class="">
            <div class="section-tags">{{ __('GAMES') }} • {{ __('APPS') }} • {{ __('MARKETING CONTENT') }} • {{ __('HELP CENTER') }} • {{ __('USER MANUALS') }}</div>
            <div>
                <h1>{{ __('Localization and LQA Services') }}</h1>
            </div>
            <div class="mt-30">{{ __('Entrust your content to us — we`ll make it sound natural, relevant, and ready to perform in every market you target.') }}</div>
            <div class="mt-8 mb-4">
                <a href="{{ route('home', app()->getLocale()) }}" class="white_btn">
                    {{ __('Book a Meeting') }}
                </a>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <div class="section-head">{{ __('WHY US') }}</div>
        <div class="content-big">{{ __('With over') }}</div>
    </section>

    <section class="mb-12">
        <div class="section-head">{{ __('RELEASE LOG') }}</div>

        <h2 class="flex justify-center text-2xl font-bold mb-6">{{ __('NEWS & INSIGHTS') }}</h2>
        
        <div class="flex border-b py-5">
            <a href="{{ route('posts.index', app()->getLocale()) }}" class="btn-arrow ml-auto">{{ __('Read all posts') }}</a>
        </div>

        @forelse($latestPosts as $post)
        <div 
            x-data="{ 
                showContent: false,
                isCollapsed: false,
                toggleContent() {
                    // Сначала уменьшаем колонку
                    this.isCollapsed = true;
                    
                    // Через 500ms показываем контент
                    setTimeout(() => {
                        this.showContent = true;
                    }, 500);
                },
                hideContent() {
                    // Сначала скрываем контент
                    this.showContent = false;
                    
                    // Через 300ms расширяем колонку
                    setTimeout(() => {
                        this.isCollapsed = false;
                    }, 300);
                }
            }"
            class="flex border-b py-3"
        >
            <div 
                :class="isCollapsed ? 'w-1/4' : 'w-full'"
                class="transition-all duration-500 overflow-hidden"
            >
                <div class="py-2">
                    <div class="flex justify-between items-center">
                        <h3 class="">{{ $post->title }}</h3>
                        
                        <button 
                            @click="showContent ? hideContent() : toggleContent()" 
                            class=""
                        >
                            <span class="white-circle-updown" x-text="showContent ? '↑' : '↓'">&nbsp;</span>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Правая часть с контентом -->
            <div class="flex-1 overflow-hidden">
                <div 
                    x-show="showContent"
                    x-transition:enter="transition-opacity duration-500"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-300"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class=""
                >
                    <div class="grid grid-cols-2 gap-4">
                        <div class="py-4 px-3">
                            <p class="text-sm">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            <div class="text-sm font-bold my-6">{{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}</div>
                            <div class="">
                                <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="black_btn">
                                    {{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="arrow-in-line">→</span>
                                </a>
                            </div>
                        </div>
                        <div class="py-4">
                            @if($post->preview_image)
                                <img src="{{ Storage::url($post->preview_image) }}" 
                                    alt="{{ $post->title }}" 
                                    class="w-full h-48 object-cover">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-500">{{ __('Новостей пока нет') }}</p>
        @endforelse
    </section>
</div>
@endsection