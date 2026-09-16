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
                <div class="relative w-full h-full overflow-hidden">
                    @foreach($topImages as $index => $image)
                        <div
                            x-show="currentIndex === {{ $index }}"
                            class="w-full h-full"
                        >
                            <img
                                src="{{ Storage::url($image->image_path) }}"
                                alt="{{ $image->getTranslation('alt_text', $locale, false) ?? '' }}"
                                class="w-full h-full object-cover rounded-[104px]"
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
                <h1 class="max-w-[600px] max-lg:max-w-[100%]">{{ __('Localization and LQA Services') }}</h1>
            </div>
            <div class="mt-8 max-w-[380px] max-sm:max-w-[100%] content-top">{{ __('Entrust your content to us — we’ll make it sound natural, relevant, and ready to perform in every market you target.') }}</div>
            <div class="mt-8 mb-4" x-data>
                <button @click="$store.contactModal.openModal()" class="white_btn">
                    {{ __('Book a Call') }}
                </button>
            </div>
        </div>
    </section>

    {{--<section id="partners" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="partners" class="mb-[132px] max-lg:mb-[196px] max-sm:mb-[87px]">
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
                @for($i=0;$i<=1;$i++) {{-- For dublicate --}}
                <div class="slide" style="background-position-x: -80px;"></div>
                <div class="slide" style="background-position-x: -455px;"></div>
                <div class="slide" style="background-position-x: -850px;"></div>
                <div class="slide" style="background-position-x: -1285px;"></div>
                <div class="slide" style="background-position-x: -1700px;"></div>
                <div class="slide" style="background-position-x: -2110px;"></div>
                <div class="slide" style="background-position-x: -2487px;"></div>
                <div class="slide" style="background-position-x: -2850px;"></div>
                <div class="slide" style="background-position-x: -3233px;"></div>
                @endfor
            </div>
        </div>
    </section>

    {{--<section id="why_us" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="why_us" class="mb-[353px] max-lg:mb-[219px] max-sm:mb-[174px]">
        <div class="section-head">{{ __('WHY US') }}</div>
        <div class="content-big">{{ __('With over 15 years of experience, we specialize in localizing games, software, user manuals, help center content, and marketing materials. We ensure every piece of content serves your audience.') }}</div>
    </section>

    {{--<section id="news" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="news" class="mb-[198px] max-lg:mb-[164px] max-sm:mb-[122px]">
        <div class="section-head">{{ __('RELEASE LOG') }}</div>

        <h2>{{ __('NEWS & INSIGHTS') }}</h2>

        {{--<div class="flex border-b py-5">
            <a href="{{ route('posts.index', app()->getLocale()) }}" class="btn-arrow ml-auto">{{ __('Read all posts') }}</a>
        </div>--}}

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
                    }, 500);
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
            class="flex max-lg:hidden max-sm:hidden border-t border-t-[#676768] pt-2"
        >
            <div
                :class="isCollapsed ? 'w-1/4' : 'w-full'"
                class="py-4 transition-all duration-300 overflow-hidden"
            >
                <div class="py-2">
                    <div
                        @click="showContent ? hideContent() : toggleContent()"
                        class="flex justify-between items-center cursor-pointer"
                    >
                        <h3 class="">{{ $post->preview_title ?? $post->title }}</h3>
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
                        <div class="order-none max-sm:order-2 post-body">
                            <div class="post-text">{{ Str::limit(strip_tags($post->content), 500) }}</div>
                            {{-- <div class="hidden max-lg:flex post-text">{{ Str::limit(strip_tags($post->content), 250) }}</div> --}}
                            <div class="post-date">{{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}</div>
                            <div class="post-button">
                                <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="view_btn">
                                    <div>{{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                </a>
                            </div>
                        </div>
                        <div class="order-none max-sm:order-1 py-6 pl-10">
                            @if($post->preview_image)
                                <img src="{{ Storage::url($post->preview_image) }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-auto object-cover rounded-[26px]">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="ml-6 py-4">
                <button
                    @click="showContent ? hideContent() : toggleContent()"
                >
                    {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                        class="w-[64px] h-[64px] flex-shrink-0"
                        :class="isCollapsed ? '' : 'rotate-180'"
                    >
                        <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                        <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                    </svg>--}}
                    <div class="sprite-arrow sprite-arrow-62-bottom-black transition-transform duration-300" :class="isCollapsed ? 'rotate-180' : 'rotate-0'"></div>
                </button>
            </div>
        </div>
        {{-- For pad devices --}}
        <div
            x-data="{
                showContent: false,
                toggleContent() {
                    this.showContent = !this.showContent;
                }
            }"
            class="hidden max-lg:flex max-sm:hidden flex-col max-sm:flex-col border-b py-3"
        >
            {{-- Верхняя строка: заголовок + стрелка (всегда видна) --}}
            <div class="flex items-center justify-between w-full" @click="toggleContent()">
                <div class="" :class="showContent ? 'invisible' : 'flex'">
                    <h3 class="cursor-pointer hover:text-blue-600 transition">
                        {{ $post->preview_title ?? $post->title }}
                    </h3>
                </div>
                <div class="ml-4 py-2">
                    <button>
                        <div class="sprite-arrow sprite-arrow-44-bottom-black transition-transform duration-300" :class="showContent ? 'rotate-180' : 'rotate-0'"></div>
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
                <div class="grid grid-cols-2 mb-[34px]">
                    <div class="order-none px-3 post-body">
                        <div class="">
                            <h3
                                @click="toggleContent()"
                                class="cursor-pointer hover:text-blue-600 transition"
                            >
                                {{ $post->preview_title ?? $post->title }}
                            </h3>
                        </div>
                        <div class="post-text">{{ Str::limit(strip_tags($post->content), 100) }}</div>
                        <div class="post-date">
                            {{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}
                        </div>
                    </div>
                    <div class="order-none">
                        @if($post->preview_image)
                            <img src="{{ Storage::url($post->preview_image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-48 object-cover rounded-[26px]">
                        @endif
                    </div>
                </div>
                <div class="post-button mb-[28px]">
                    <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="view_btn">
                        <div>{{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                    </a>
                </div>
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
                        {{ $post->preview_title ?? $post->title }}
                    </h3>
                </div>

                <div class="ml-4 py-2">
                    <button @click="toggleContent()">
                        {{--<span class="white-circle-updown" x-text="showContent ? '↑' : '↓'">&nbsp;</span>--}}
                        <div class="sprite-arrow sprite-arrow-44-bottom-black transition-transform duration-300" :class="showContent ? 'rotate-180' : 'rotate-0'"></div>
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
                    <div class="order-1 mb-[15px]">
                        @if($post->preview_image)
                            <img src="{{ Storage::url($post->preview_image) }}"
                                alt="{{ $post->title }}"
                                class="w-full h-48 object-cover rounded-[26px]">
                        @endif
                    </div>
                    {{-- Текст --}}
                    <div class="order-2 px-3 post-body">
                        <div class="post-text">{{ Str::limit(strip_tags($post->content), 100) }}</div>
                        <div class="post-date">
                            {{ $post->published_at->isoFormat('D MMMM YYYY') }} • {{ $post->reading_time }} {{ __('MIN READ') }}
                        </div>
                        <div class="post-button">
                            <a href="{{ route('posts.show', [app()->getLocale(), $post->slug]) }}" class="view_btn">
                                <div>{{ __('View post') }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div></div>
        @endforelse
        <div class="flex max-sm:hidden border-t border-t-[#676768]">&nbsp;</div>
    </section>

    {{--<section id="projects" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="projects" class="mb-[236px] max-lg:mb-[166px] max-sm:mb-[136px]">
        <div class="section-head">{{ __('PROJECTS') }}</div>

        <div class="flex justify-center text-center">
            <h2 class="max-w-[1004px] max-lg:max-w-[670px] ">{{ __('GAMES WE HELPED BRING TO THE WORLD') }}</h2>
        </div>

        @if($projectImages->count())
            <div class="relative w-full overflow-hidden py-8" x-data="{ activeImage: null }">
                <div class="flex animate-scroll-projects" style="--scroll-duration: {{ $projectImages->count() * 30 }}s;">
                    @for($i=0;$i<=1;$i++)
                        @foreach($projectImages as $image)
                            <div class="projects_image group"
                                @click="activeImage = activeImage === {{ $image->id }} ? null : {{ $image->id }}"
                            >
                                <img
                                    src="{{ Storage::url($image->image_path) }}"
                                    alt="{{ $image->title }}"
                                    loading="lazy"
                                >
                                <div
                                    class="absolute inset-0 transition-all duration-300 flex flex-col justify-between"
                                    :class="activeImage === {{ $image->id }}
                                        ? 'bg-black/60 opacity-100'
                                        : 'bg-black/0 opacity-0 md:group-hover:bg-black/60 md:group-hover:opacity-100'"
                                >
                                    <div class="flex w-full justify-center text-center pt-[80px]">
                                        <h3>{{ $image->title }}</h3>
                                    </div>
                                    <div class="projects_comment flex w-full justify-center text-center pb-[80px]">
                                        @if($image->comment)
                                            {{ Str::limit(strip_tags($image->comment), 1000) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endfor
                </div>
            </div>
        @endif
    </section>

    {{--<section id="services" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="services" class="mb-[128px] max-lg:mb-[112px] max-sm:mb-[68px]">
        <div class="section-head">{{ __('SERVICES') }}</div>

        <div class="flex justify-center text-center">
            <h2 class="max-w-[1180px]">{{ __('COMPLETE CONTENT & LOCALIZATION SOLUTIONS') }}</h2>
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
                        class="block w-full h-full object-cover rounded-[32px]"
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
                        class="w-full h-full object-cover rounded-[32px]"
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
                        class="w-full h-full object-cover rounded-[32px]"
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
                        class="w-full h-full object-cover rounded-[32px]"
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
                        @click="activeIndex = 0"
                    >
                        <h3>
                            {{ __('Software & Mobile App') }}
                        </h3>
                        {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                'hidden': activeIndex === 0,
                                'rotate-180': activeIndex !== 0
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>--}}
                        <div class="sprite-arrow sprite-arrow-48-bottom-black max-sm:sprite-arrow-44-bottom-black ml-[5px]" :class="{'hidden': activeIndex === 0, 'rotate-180': activeIndex !== 0}"></div>
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
                        @click="activeIndex = 1"
                    >
                        <h3>
                            {{ __('In-Game Experience') }}
                        </h3>
                        {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                'hidden': activeIndex === 1,
                                'rotate-180': activeIndex !== 1
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>--}}
                        <div class="sprite-arrow sprite-arrow-48-bottom-black max-sm:sprite-arrow-44-bottom-black ml-[5px]" :class="{'hidden': activeIndex === 1, 'rotate-180': activeIndex !== 1}"></div>
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
                        @click="activeIndex = 2"
                    >
                        <h3>
                            {{ __('Audio Production & Voice-Overing') }}
                        </h3>
                        {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-[64px] h-[64px] flex-shrink-0"
                            :class="{
                                'hidden': activeIndex === 2,
                                'rotate-180': activeIndex !== 2
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>--}}
                        <div class="sprite-arrow sprite-arrow-48-bottom-black max-sm:sprite-arrow-44-bottom-black ml-[5px]" :class="{'hidden': activeIndex === 2, 'rotate-180': activeIndex !== 2}"></div>
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
                        @click="activeIndex = 3"
                    >
                        <h3>
                            {{ __('Localization') }}
                        </h3>
                        {{--<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="#e4e4e4" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                            class="w-16 h-16 flex-shrink-0"
                            :class="{
                                'hidden': activeIndex === 3,
                                'rotate-180': activeIndex !== 3
                            }"
                        >
                            <circle cx="12" cy="12" r="10" fill="none" stroke="#e4e4e4"/>
                            <path d="M12 17V8M9 11l3-3 3 3" stroke="#e4e4e4" stroke-width="1"/>
                        </svg>--}}
                        <div class="sprite-arrow sprite-arrow-48-bottom-black max-sm:sprite-arrow-44-bottom-black ml-[5px]" :class="{'hidden': activeIndex === 3, 'rotate-180': activeIndex !== 3}"></div>
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

    {{--<section id="video" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    {{--<section id="video" class="mb-[200px] max-lg:mb-[112px] max-sm:mb-[68px]">
        <div class="grid grid-cols-2 gap-5">
            <div class="order-none">
                <img src="/images/video-anna.jpg" alt="{{ __('Video about Localization') }}" class="w-full h-auto rounded-[48px]">
            </div>
            <div class="order-none">
                <img src="/images/video-studio.jpg" alt="{{ __('Video about Localization Studio') }}" class="w-full h-auto rounded-[96px]">
            </div>
        </div>
    </section>--}}

    {{--<section id="call" class="mb-60 max-lg:mb-40 max-sm:mb-20">--}}
    <section id="call" class="mb-[182px] max-lg:mb-[176px] max-sm:mb-[292px]">
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