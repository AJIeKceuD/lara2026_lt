@extends('layouts.app')

@section('title', __('Home'))

@section('content')
<div class="container max-lg:max-w-[100%] mx-auto px-4 py-8">
    <section id="top" class="grid grid-cols-2 max-sm:grid-cols-1 px-0">
        <div class="order-none max-sm:order-2 mr-[15%] max-lg:mr-0">
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
                class="relative w-full aspect-square mx-auto"
            >
                <div class="relative w-full h-full rounded-[104px] overflow-hidden">
                    @foreach($topImages as $index => $image)
                        <div
                            x-show="currentIndex === {{ $index }}"
                            class="w-full h-full"
                        >
                            <img
                                src="{{ Storage::url($image->image_path) }}"
                                alt="{{ $image->getTranslation('alt_text', $locale, false) ?? '' }}"
                                class="w-full h-full object-contain"
                                loading="lazy"
                            >
                        </div>
                    @endforeach
                </div>

                @if($topImages->count() > 1)
                    <!--button @click="previous()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10">◀</button>
                    <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg z-10">▶</button-->

                    <div class="absolute left-14 max-lg:left-7 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-10">
                        <template x-for="index in total" :key="index">
                            <button
                                @click="goTo(index - 1)"
                                class="rounded-full transition-all duration-300"
                                :class="{
                                    'bg-white w-1.5 h-8': currentIndex === (index - 1),
                                    'bg-gray-400 w-1.5 h-8': currentIndex !== (index - 1)
                                }"
                            ></button>
                        </template>
                    </div>
                @endif
            </div>
        @endif
        </div>

        {{-- <div class="mr-auto justify-start">
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
        </div>--}}
        <div class="order-none max-sm:order-1 max-lg:ml-[10%] max-sm:ml-0">
            <div class="section-tags">{{ __('GAMES') }} • {{ __('SOFTWARE') }} • {{ __('USER MANUALS') }} • {{ __('HELP CENTER') }} • {{ __('MARKETING') }}</div>
            <div>
                <h1>{{ __('Localization and LQA Services') }}</h1>
            </div>
            <div class="mt-8 max-w-[380px] max-sm:max-w-[100%] text-[20px] max-sm:text-[19px] text-[#919191] max-lg:leading-tight">{{ __('Entrust your content to us — we’ll make it sound natural, relevant, and ready to perform in every market you target.') }}</div>
            <div class="mt-8 mb-4" x-data>
                <button @click="$store.contactModal.openModal()" class="white_btn">
                    {{ __('Book a Call') }}
                </button>
            </div>
        </div>
    </section>

    <section id="partners" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="slider-wrapper">
            <div class="slider-track">
                {{-- @for ($copy = 0; $copy < 2; $copy++)
                    @foreach (range(1, 5) as $index)
                        <div
                            class="slide"
                            style="background-position: {{ ($index - 1) * -20 }}% 0;"
                        ></div>
                    @endforeach
                @endfor --}}
                <div class="slide" style="background-position-x: 0%;"></div>
                <div class="slide" style="background-position-x: 25%;"></div>
                <div class="slide" style="background-position-x: 50%;"></div>
                <div class="slide" style="background-position-x: 75%;"></div>
                <div class="slide" style="background-position-x: 100%;"></div>
                <div class="slide" style="background-position-x: 0%;"></div>
                <div class="slide" style="background-position-x: 25%;"></div>
                <div class="slide" style="background-position-x: 50%;"></div>
                <div class="slide" style="background-position-x: 75%;"></div>
                <div class="slide" style="background-position-x: 100%;"></div>
            </div>
        </div>
    </section>

    <section id="why_us" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="section-head">{{ __('WHY US') }}</div>
        <div class="content-big">{{ __('With over 15 years of experience, we specialize in localizing games, software, user manuals, help center content, and marketing materials. We ensure every piece of content serves your audience.') }}</div>
    </section>

    <section id="news" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="section-head">{{ __('RELEASE LOG') }}</div>

        <h2>{{ __('NEWS & INSIGHTS') }}</h2>

        <div class="flex border-b py-5">
            <a href="{{ route('posts.index', app()->getLocale()) }}" class="btn-arrow ml-auto">{{ __('Read all posts') }}</a>
        </div>

        @forelse($latestPosts as $post)
        {{-- For PC --}}
        <div
            x-data="{
                showContent: false,
                isCollapsed: false,
                toggleContent() {
                    // First colapse colon
                    this.isCollapsed = true;

                    // After 500ms show content
                    setTimeout(() => {
                        this.showContent = true;
                    }, 300);
                },
                hideContent() {
                    // First hide content
                    this.showContent = false;

                    // After 300ms show colon
                    setTimeout(() => {
                        this.isCollapsed = false;
                    }, 100);
                }
            }"
            class="flex max-sm:hidden border-b py-3"
        >
            <div
                :class="isCollapsed ? 'w-1/4' : 'w-full'"
                class="py-4 transition-all duration-100 overflow-hidden"
            >
                <div class="py-2">
                    <div
                        @click="showContent ? hideContent() : toggleContent()"
                        class="flex justify-between items-center cursor-pointer"
                    >
                        <h3 class="">{{ $post->title }}</h3>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-hidden">
                <div
                    x-show="showContent"
                    x-transition:enter="transition-opacity duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class=""
                >
                    <div class="grid grid-cols-2 max-sm:grid-cols-1 gap-4">
                        <div class="order-none max-sm:order-2 py-4 px-3 post-body">
                            <div>{{ Str::limit(strip_tags($post->content), 100) }}</div>
                            <div class="my-6">{{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}</div>
                            <div>
                                <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="view_btn">
                                    {{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="arrow-in-line">→</span>
                                </a>
                            </div>
                        </div>
                        <div class="order-none max-sm:order-1 py-4">
                            @if($post->preview_image)
                                <img src="{{ Storage::url($post->preview_image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-48 object-cover rounded-[26px]">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-6 py-4">
                <button
                    @click="showContent ? hideContent() : toggleContent()"
                >
                    <span class="white-circle-updown" x-text="showContent ? '↑' : '↓'">&nbsp;</span>
                </button>
            </div>
        </div>
        {{-- For mobile devices --}}
        <div
            x-data="{
                showContent: false,
                toggleContent() {
                    this.showContent = !this.showContent;
                }
            }"
            class="hidden max-sm:flex flex-col max-sm:flex-col border-b py-3"
        >
            {{-- Верхняя строка: заголовок + стрелка (всегда видна) --}}
            <div class="flex items-center justify-between w-full">
                <div class="flex-1 py-2">
                    <h3
                        @click="toggleContent()"
                        class="cursor-pointer hover:text-blue-600 transition"
                    >
                        {{ $post->title }}
                    </h3>
                </div>

                <div class="ml-4 py-2">
                    <button @click="toggleContent()">
                        <span class="white-circle-updown" x-text="showContent ? '↑' : '↓'">&nbsp;</span>
                    </button>
                </div>
            </div>

            {{-- Контент (раскрывается под заголовком) --}}
            <div
                x-show="showContent"
                x-transition:enter="transition-all duration-300 ease-out"
                x-transition:enter-start="opacity-0 -translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition-all duration-200 ease-in"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-4"
                class="w-full overflow-hidden"
            >
                <div class="grid grid-cols-1">
                    {{-- Картинка --}}
                    <div class="order-1">
                        @if($post->preview_image)
                            <img src="{{ Storage::url($post->preview_image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-48 object-cover rounded-[26px]">
                        @endif
                    </div>
                    {{-- Текст --}}
                    <div class="order-2 px-3 post-body">
                        <div>{{ Str::limit(strip_tags($post->content), 100) }}</div>
                        <div class="my-6 text-sm text-gray-500">
                            {{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}
                        </div>
                        <div>
                            <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="view_btn inline-flex justify-center items-center w-full">
                                {{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;<span class="arrow-in-line pb-[10px]">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div></div>
        @endforelse
    </section>

    <section id="projects" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="section-head">{{ __('PROJECTS') }}</div>

        <h2>{{ __('GAMES WE HELPED') }}<br />{{ __('BRING TO THE WORLD') }}</h2>
    </section>

    <section id="services" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="section-head">{{ __('SERVICES') }}</div>

        <h2>{{ __('COMPLETE CONTENT &') }}<br />{{ __('LOCALIZATION SOLUTIONS') }}</h2>

        <div x-data="{
            activeIndex: 0,
            total: 4,
            autoplayInterval: null,
            autoplayDelay: 4000,
            {{-- init() {
                if (this.total > 1) this.startAutoplay()
            },
            startAutoplay() {
                this.autoplayInterval = setInterval(() => {
                    this.next()
                }, this.autoplayDelay)
            },
            stopAutoplay() {
                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval)
                    this.autoplayInterval = null
                }
            }, --}}
            next() {
                this.activeIndex = (this.activeIndex + 1) % this.total
            },
            previous() {
                this.activeIndex = (this.activeIndex - 1 + this.total) % this.total
            },
            goTo(index) {
                this.activeIndex = index
                {{-- this.stopAutoplay()
                this.startAutoplay() --}}
            }
        }"
        class="hidden grid grid-cols-2 gap-12 mr-[20%] items-stretch max-lg:mr-0"
        >
            {{-- ЛЕВАЯ ЧАСТЬ: Слайдер картинок --}}
            <div class="relative w-full aspect-square bg-gray-100 rounded-2xl overflow-hidden shadow-lg">
                <div
                    x-show="activeIndex === 0"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                >
                    <img src="/images/services/service_1.jpg" alt="Slide 1" class="w-full h-full object-cover">
                </div>
                <div
                    x-show="activeIndex === 1"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                >
                    <img src="/images/services/service_2.jpg" alt="Slide 2" class="w-full h-full object-cover">
                </div>
                <div
                    x-show="activeIndex === 2"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                >
                    <img src="/images/services/service_3.jpg" alt="Slide 3" class="w-full h-full object-cover">
                </div>
                <div
                    x-show="activeIndex === 3"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full"
                >
                    <img src="/images/services/service_4.jpg" alt="Slide 4" class="w-full h-full object-cover">
                </div>
            </div>

            {{-- ПРАВАЯ ЧАСТЬ: Аккордеон --}}
            <div class="flex flex-col gap-2 h-full min-h-[700px] max-lg:min-h-[500px]">
                {{-- Пункт 1 --}}
                <div
                    class="services-texts-child"
                    :class="{
                        'flex-1': activeIndex === 0,
                        'flex-shrink-0': activeIndex !== 0
                    }"
                >
                    <button @click="goTo(0)">
                        <h3>
                            {{ __('Software & Mobile App') }}
                        </h3>
                        {{-- <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-300"
                            :class="{
                                'rotate-180 text-blue-600': activeIndex === 0,
                                'text-gray-400': activeIndex !== 0
                            }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>

                    <div
                        x-show="activeIndex === 0"
                        x-collapse.duration.300
                        class="flex-1 px-5 pb-5 pt-0"
                    >
                        <div class="h-full overflow-y-hidden leading-relaxed">
                            <div>
                                {{ __('Localization that feels native on every platform. We adapt interfaces with precision and creativity, ensuring every player experience stays authentic and seamless.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('UI and UX Elements, Settings & Preferences, Technical Documentation, Knowledge Base or Help Center, Emails and Notifications, Release Notes, Manuals and Guides, User agreements and Terms of service.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 2 --}}
                <div
                    class="services-texts-child"
                    :class="{
                        'flex-1': activeIndex === 1,
                        'flex-shrink-0': activeIndex !== 1
                    }"
                >
                    <button @click="goTo(1)">
                        <h3>
                            {{ __('In-Game Experience') }}
                        </h3>
                        {{-- <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-300"
                            :class="{
                                'rotate-180 text-blue-600': activeIndex === 1,
                                'text-gray-400': activeIndex !== 1
                            }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>

                    <div
                        x-show="activeIndex === 1"
                        x-collapse.duration.300
                        class="flex-1 px-5 pb-5 pt-0"
                    >
                        <div class="h-full overflow-y-auto leading-relaxed">
                            <div>
                                {{ __('Giving every story its true voice and emotional impact. From casting and recording to trailers, ads, and social media — we bring characters and worlds to life with high-quality voice work and cultural nuance.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('UI and UX Elements, In-Game Text, Dialogs, Scripts, Tutorials, FAQs, Subtitles, troubleshooting guides, Song lyrics.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 3 --}}
                <div
                    class="services-texts-child"
                    :class="{
                        'flex-1': activeIndex === 2,
                        'flex-shrink-0': activeIndex !== 2
                    }"
                >
                    <button @click="goTo(2)">
                        <h3>
                            {{ __('Audio Production & Voice-Overing') }}
                        </h3>
                        {{-- <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-300"
                            :class="{
                                'rotate-180 text-blue-600': activeIndex === 2,
                                'text-gray-400': activeIndex !== 2
                            }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>

                    <div
                        x-show="activeIndex === 2"
                        x-collapse.duration.300
                        class="flex-1 px-5 pb-5 pt-0"
                    >
                        <div class="h-full overflow-y-auto leading-relaxed">
                            <div>
                                {{ __('Live and database casting, authentic voices, pronunciation guides, sound design, script adaptation, recording studios and team.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('Live and database casting, authentic voices, pronunciation guides, sound design, script adaptation, recording studios and team.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 4 --}}
                <div
                    class="services-texts-child"
                    :class="{
                        'flex-1': activeIndex === 3,
                        'flex-shrink-0': activeIndex !== 3
                    }"
                >
                    <button @click="goTo(3)">
                        <h3>
                            {{ __('Localization') }}
                        </h3>
                        {{-- <svg
                            class="w-5 h-5 flex-shrink-0 transition-transform duration-300"
                            :class="{
                                'rotate-180 text-blue-600': activeIndex === 3,
                                'text-gray-400': activeIndex !== 3
                            }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"9
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg> --}}
                    </button>

                    <div
                        x-show="activeIndex === 3"
                        x-collapse.duration.300
                        class="flex-1 px-5 pb-5 pt-0"
                    >
                        <div class="">
                            <div>
                                {{ __('A blend of handcrafted and AI-powered translation ensures that even poems and jokes feel natural. With Translation Memory, style guides, glossaries, and cross-platform terminology, your content stays on brand and sounds native to the audience.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('5 Recording studios, 40+ Successful projects, 15 Years on market, AI Hybrid Translation.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-data="{ activeIndex: 0 }"
            class="grid grid-cols-2 max-sm:grid-cols-1 items-start gap-12 max-lg:gap-8 mr-[20%] max-lg:mr-0"
        >
            {{-- ===== ЛЕВАЯ ЧАСТЬ: Картинка ===== --}}
            <div class="relative w-full h-[800px] overflow-hidden max-sm:hidden">
                {{-- Картинка 1 --}}
                <div
                    x-show="activeIndex === 0"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full transform-gpu will-change-transform will-change-opacity flex items-center justify-center"
                    style="transform-origin: center center;"
                >
                    <img
                        src="/images/services/service_1.jpg"
                        alt="Software & Mobile App"
                        class="w-full h-full object-contain rounded-[32px]"
                        loading="lazy"
                    >
                </div>

                {{-- Картинка 2 --}}
                <div
                    x-show="activeIndex === 1"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full transform-gpu will-change-transform will-change-opacity flex items-center justify-center"
                    style="transform-origin: center center;"
                >
                    <img
                        src="/images/services/service_2.jpg"
                        alt="In-Game Experience"
                        class="w-full h-full object-contain rounded-[32px]"
                        loading="lazy"
                    >
                </div>

                {{-- Картинка 3 --}}
                <div
                    x-show="activeIndex === 2"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full transform-gpu will-change-transform will-change-opacity flex items-center justify-center"
                    style="transform-origin: center center;"
                >
                    <img
                        src="/images/services/service_3.jpg"
                        alt="Audio Production & Voice-Overing"
                        class="w-full h-full object-contain rounded-[32px]"
                        loading="lazy"
                    >
                </div>

                {{-- Картинка 4 --}}
                <div
                    x-show="activeIndex === 3"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 w-full h-full transform-gpu will-change-transform will-change-opacity flex items-center justify-center"
                    style="transform-origin: center center;"
                >
                    <img
                        src="/images/services/service_4.jpg"
                        alt="Localization"
                        class="w-full h-full object-contain rounded-[32px]"
                        loading="lazy"
                    >
                </div>
            </div>

            {{-- ===== ПРАВАЯ ЧАСТЬ: Аккордеон ===== --}}
            <div class="flex flex-col gap-2">
                {{-- Пункт 1 --}}
                <div
                    class="services-texts-child"
                >
                    <button
                        @click="activeIndex = activeIndex === 0 ? -1 : 0"
                    >
                        <h3>
                            {{ __('Software & Mobile App') }}
                        </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                '': activeIndex === 0,
                                'rotate-180': activeIndex !== 0
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>
                    </button>

                    <div
                        x-show="activeIndex === 0"
                        x-collapse.duration.300
                        class=""
                    >
                        <div class="">
                            <div>
                                {{ __('Localization that feels native on every platform. We adapt interfaces with precision and creativity, ensuring every player experience stays authentic and seamless.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('UI and UX Elements, Settings & Preferences, Technical Documentation, Knowledge Base or Help Center, Emails and Notifications, Release Notes, Manuals and Guides, User agreements and Terms of service.') }}
                            </div>
                            <div>&nbsp;</div>
                            <div class="hidden max-sm:flex">
                                <img src="/images/services/service_1.jpg"
                                    alt="Software & Mobile App"
                                    class="w-full h-[400px] object-cover rounded-[26px]">
                            </div>
                            <div class="hidden max-sm:flex">&nbsp;</div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 2 --}}
                <div
                    class="services-texts-child"
                >
                    <button
                        @click="activeIndex = activeIndex === 1 ? -1 : 1"
                    >
                        <h3>
                            {{ __('In-Game Experience') }}
                        </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                '': activeIndex === 1,
                                'rotate-180': activeIndex !== 1
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>
                    </button>

                    <div
                        x-show="activeIndex === 1"
                        x-collapse.duration.300
                        class=""
                    >
                        <div class="">
                            <div>
                                {{ __('Giving every story its true voice and emotional impact. From casting and recording to trailers, ads, and social media — we bring characters and worlds to life with high-quality voice work and cultural nuance.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('UI and UX Elements, In-Game Text, Dialogs, Scripts, Tutorials, FAQs, Subtitles, troubleshooting guides, Song lyrics.') }}
                            </div>
                            <div>&nbsp;</div>
                            <div class="hidden max-sm:flex">
                                <img src="/images/services/service_2.jpg"
                                    alt="In-Game Experience"
                                    class="w-full h-[400px] object-cover rounded-[26px]">
                            </div>
                            <div class="hidden max-sm:flex">&nbsp;</div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 3 --}}
                <div
                    class="services-texts-child"
                >
                    <button
                        @click="activeIndex = activeIndex === 2 ? -1 : 2"
                    >
                        <h3>
                            {{ __('Audio Production & Voice-Overing') }}
                        </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                '': activeIndex === 2,
                                'rotate-180': activeIndex !== 2
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>
                    </button>

                    <div
                        x-show="activeIndex === 2"
                        x-collapse.duration.300
                        class=""
                    >
                        <div class="">
                            <div>
                                {{ __('Live and database casting, authentic voices, pronunciation guides, sound design, script adaptation, recording studios and team.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('Live and database casting, authentic voices, pronunciation guides, sound design, script adaptation, recording studios and team.') }}
                            </div>
                            <div>&nbsp;</div>
                            <div class="hidden max-sm:flex">
                                <img src="/images/services/service_3.jpg"
                                    alt="Audio Production & Voice-Overing"
                                    class="w-full h-[400px] object-cover rounded-[26px]">
                            </div>
                            <div class="hidden max-sm:flex">&nbsp;</div>
                        </div>
                    </div>
                </div>

                {{-- Пункт 4 --}}
                <div
                    class="services-texts-child"
                >
                    <button
                        @click="activeIndex = activeIndex === 3 ? -1 : 3"
                    >
                        <h3>
                            {{ __('Localization') }}
                        </h3>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-16 h-16 flex-shrink-0"
                            :class="{
                                '': activeIndex === 3,
                                'rotate-180': activeIndex !== 3
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>
                    </button>

                    <div
                        x-show="activeIndex === 3"
                        x-collapse.duration.300
                        class=""
                    >
                        <div class="">
                            <div>
                                {{ __('A blend of handcrafted and AI-powered translation ensures that even poems and jokes feel natural. With Translation Memory, style guides, glossaries, and cross-platform terminology, your content stays on brand and sounds native to the audience.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('5 Recording studios, 40+ Successful projects, 15 Years on market, AI Hybrid Translation.') }}
                            </div>
                            <div>&nbsp;</div>
                            <div class="hidden max-sm:flex">
                                <img src="/images/services/service_4.jpg"
                                    alt="Localization"
                                    class="w-full h-[400px] object-cover rounded-[26px]">
                            </div>
                            <div class="hidden max-sm:flex">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="call" class="mb-60 max-lg:mb-40 max-sm:mb-20">
        <div class="section-head">{{ __('SCHEDULE A CALL') }}</div>
        <div class="content-big">{{ __('Let’s talk about your project, goals, and how we can bring them to life.') }}</div>
        <div class="flex justify-center items-center mt-12" x-data>
            <button @click="$store.contactModal.openModal()" class="white_btn">
                {{ __('Book a Call') }}
            </button>
        </div>
    </section>
</div>
@endsection