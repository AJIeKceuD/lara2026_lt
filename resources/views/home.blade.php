@extends('layouts.app')

@section('title', __('Home'))

@section('content')
<div class="container mx-auto px-4 py-8">
    <section id="top" class="grid grid-cols-1 md:grid-cols-2 px-4 md:px-0">
        <div class="order-1 md:order-none px-[3%]">
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
                <div class="relative w-full h-full rounded-lg">
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

                    <div class="absolute left-7 md:left-14 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-10">
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
        <div class="order-2 md:order-none ">
            <div class="section-tags">{{ __('GAMES') }} • {{ __('APPS') }} • {{ __('MARKETING CONTENT') }} • {{ __('HELP CENTER') }} • {{ __('USER MANUALS') }}</div>
            <div>
                <h1>{{ __('Localization and LQA Services') }}</h1>
            </div>
            <div class="mt-8 md:mt-30">{{ __('Entrust your content to us — we`ll make it sound natural, relevant, and ready to perform in every market you target.') }}</div>
            <div class="mt-8 mb-4" x-data>
                <button @click="$store.contactModal.openModal()" class="white_btn">
                    {{ __('Book a Meeting') }}
                </button>
            </div>
        </div>
    </section>

    <section id="partners" class="mb-10 md:mb-60">
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

    <section id="why_us" class="mb-10 md:mb-60">
        <div class="section-head">{{ __('WHY US') }}</div>
        <div class="content-big">{{ __('With over') }}</div>
    </section>

    <section id="news" class="mb-10 md:mb-60">
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
                    <div
                        @click="showContent ? hideContent() : toggleContent()"
                        class="flex justify-between items-center cursor-pointer"
                    >
                        <h3 class="">{{ $post->title }}</h3>

                        <button class="">
                            <span class="white-circle-updown" x-text="showContent ? '→' : '↓'">&nbsp;</span>
                        </button>
                    </div>
                </div>
            </div>

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
            <div></div>
        @endforelse
    </section>

    <section id="projects" class="mb-10 md:mb-60">
        <div class="section-head">{{ __('PROJECTS') }}</div>

        <h2 class="flex justify-center text-2xl font-bold text-center mb-6">{{ __('GAMES WE HELPED') }}<br />{{ __('BRING TO THE WORLD') }}</h2>
    </section>

    <section id="services" class="mb-10 md:mb-60">
        <div class="section-head">{{ __('SERVICES') }}</div>

        <h2 class="flex justify-center text-2xl font-bold text-center mb-6">{{ __('COMPLETE CONTENT &') }}<br />{{ __('LOCALIZATION SOLUTIONS') }}</h2>

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
        class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 md:mr-[20%] items-stretch"
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
            <div class="flex flex-col gap-2 h-full min-h-[500px] md:min-h-[700px]">
                {{-- Пункт 1 --}}
                <div
                    class="services-texts-child"
                    :class="{
                        'flex-1': activeIndex === 0,
                        'flex-shrink-0': activeIndex !== 0
                    }"
                >
                    <button @click="goTo(0)">
                        <span :class="{
                            'flex-1': activeIndex === 0,
                            'flex-shrink-0': activeIndex !== 0
                        }">
                            {{ __('First Title') }}
                        </span>
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
                        <div class="h-full overflow-y-hidden text-gray-400 text-sm md:text-base leading-relaxed">
                            <div>
                                {{ __('Content for first title. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') }}
                            </div>
                            <div class="mt-6 section-tags">
                                {{ __('Content for first title. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.') }}
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
                        <span :class="{
                            'flex-1': activeIndex === 1,
                            'flex-shrink-0': activeIndex !== 1
                        }">
                            {{ __('Second Title') }}
                        </span>
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
                        <div class="h-full overflow-y-auto text-gray-400 text-sm md:text-base leading-relaxed">
                            {{ __('Content for second title. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.') }}
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
                        <span :class="{
                            'flex-1': activeIndex === 2,
                            'flex-shrink-0': activeIndex !== 2
                        }">
                            {{ __('Third Title') }}
                        </span>
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
                        <div class="h-full overflow-y-auto text-gray-400 text-sm md:text-base leading-relaxed">
                            {{ __('Content for third title. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.') }}
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
                        <span :class="{
                            'flex-1': activeIndex === 3,
                            'flex-shrink-0': activeIndex !== 3
                        }">
                            {{ __('Fourth Title') }}
                        </span>
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
                        <div class="h-full overflow-y-auto text-gray-400 text-sm md:text-base leading-relaxed">
                            {{ __('Content for fourth title. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="call" class="mb-10 md:mb-60">
        <div class="section-head">{{ __('SCHEDULE A CALL') }}</div>
        <div class="content-big">{{ __('Lets talk') }}</div>
        <div class="flex justify-center items-center mt-12" x-data>
            <button @click="$store.contactModal.openModal()" class="white_btn">
                {{ __('Book a Meeting') }}
            </button>
        </div>
    </section>
</div>
@endsection