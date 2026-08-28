<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400&family=Onest:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/ltls.css'])
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <nav class="shadow-md sticky top-0 z-50 bg-ltls-black">
        <div class="container mx-auto px-4 py-3">
            <div class="flex max-sm:hidden grid grid-cols-3 max-lg:grid-cols-2 gap-4">
                <div class="justify-start relative">
                    {{-- Десктопное меню --}}
                    <div class="flex items-center justify-start gap-2">
                        @foreach(['en', 'zh'] as $lang)
                            @php
                                if (app()->getLocale() == $lang) {
                                    continue;
                                }
                                // Получаем текущий путь БЕЗ языкового префикса
                                $currentPath = request()->path();
                                $segments = explode('/', $currentPath);

                                // Убираем первый сегмент если это язык
                                if (in_array($segments[0] ?? '', ['en', 'zh'])) {
                                    array_shift($segments);
                                }

                                // Собираем путь без языка
                                $pathWithoutLocale = implode('/', $segments);

                                // Формируем новый URL с новым языком
                                $newUrl = $pathWithoutLocale ? "/{$lang}/{$pathWithoutLocale}" : "/{$lang}";
                            @endphp
                            <a href="{{ $newUrl }}" class="inline-flex items-center black_btn">
                                <!-- Globe SVG Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe" viewBox="0 0 16 16">
                                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/>
                                </svg>
                                <span>&nbsp;{{ strtoupper($lang) }}</span>
                            </a>
                        @endforeach
                        <a href="{{ route('home', app()->getLocale()) }}#news" class="black_btn">
                            {{ __('Blog') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#projects" class="black_btn">
                            {{ __('Projects') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#services" class="black_btn">
                            {{ __('Services') }}
                        </a>
                    </div>
                </div>
                <div class="flex justify-center items-center max-lg:hidden">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        <img
                            src="/images/logo_white.png"
                            alt="Loki translate"
                            class="w-[45px] h-[45px]"
                        >
                    </a>
                </div>
                <div class="ml-auto" x-data>
                    <button @click="$store.contactModal.openModal()" class="white_btn">
                        {{ __('Book a Call') }}
                    </button>
                    <!-- Language switcher -->
                    {{--<div class="flex gap-2 ml-4">
                        @foreach(['en', 'zh'] as $lang)
                            @php
                                // Получаем текущий путь БЕЗ языкового префикса
                                $currentPath = request()->path();
                                $segments = explode('/', $currentPath);

                                // Убираем первый сегмент если это язык
                                if (in_array($segments[0] ?? '', ['en', 'zh'])) {
                                    array_shift($segments);
                                }

                                // Собираем путь без языка
                                $pathWithoutLocale = implode('/', $segments);

                                // Формируем новый URL с новым языком
                                $newUrl = $pathWithoutLocale ? "/{$lang}/{$pathWithoutLocale}" : "/{$lang}";
                            @endphp
                            <a href="{{ $newUrl }}"
                            class="{{ app()->getLocale() == $lang ? 'font-bold text-blue-600' : '' }}">
                                {{ strtoupper($lang) }}
                            </a>
                        @endforeach
                    </div>--}}
                </div>
            </div>

            <div class="hidden max-sm:flex grid grid-cols-2">
                <div class="flex justify-center items-center">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        <img
                            src="/images/logo_white.png"
                            alt="Loki translate"
                            class="w-[45px] h-[45px]"
                        >
                    </a>
                </div>
                <div x-data="{ mobileMenuOpen: false }" class="ml-auto">
                    {{-- Бургер-иконка (только на мобильных) --}}
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="black_btn"
                        aria-label="Toggle menu"
                    >{{ __('Menu') }}
                        {{--<span class="block w-6 h-0.5 bg-ltls-white transition-transform duration-300"
                            :class="{ 'rotate-45 translate-y-2': mobileMenuOpen }"></span>
                        <span class="block w-6 h-0.5 bg-ltls-white transition-opacity duration-300"
                            :class="{ 'opacity-0': mobileMenuOpen }"></span>
                        <span class="block w-6 h-0.5 bg-ltls-white transition-transform duration-300"
                            :class="{ '-rotate-45 -translate-y-2': mobileMenuOpen }"></span>--}}
                    </button>

                    {{-- Мобильное меню (выпадающее) --}}
                    <div
                        x-show="mobileMenuOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-4"
                        class="absolute top-full left-0 right-0 bg-black rounded-b-[40px] p-4 z-50 flex flex-col gap-2"
                        @click.away="mobileMenuOpen = false"
                    >
                        <a href="{{ route('home', app()->getLocale()) }}#news" class="mobile_btn" @click="mobileMenuOpen = false">
                            {{ __('Blog') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#projects" class="mobile_btn" @click="mobileMenuOpen = false">
                            {{ __('Projects') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#services" class="mobile_btn" @click="mobileMenuOpen = false">
                            {{ __('Services') }}
                        </a>
                        @foreach(['en', 'zh'] as $lang)
                            @php
                                if (app()->getLocale() == $lang) {
                                    continue;
                                }
                                // Получаем текущий путь БЕЗ языкового префикса
                                $currentPath = request()->path();
                                $segments = explode('/', $currentPath);

                                // Убираем первый сегмент если это язык
                                if (in_array($segments[0] ?? '', ['en', 'zh'])) {
                                    array_shift($segments);
                                }

                                // Собираем путь без языка
                                $pathWithoutLocale = implode('/', $segments);

                                // Формируем новый URL с новым языком
                                $newUrl = $pathWithoutLocale ? "/{$lang}/{$pathWithoutLocale}" : "/{$lang}";
                            @endphp
                            <a href="{{ $newUrl }}" class="mobile_btn !text-[#919191]">
                                {{ __("language." . $lang) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{--<div class="flex justify-between items-center">
                <div class="flex gap-4">
                    <a href="{{ route('home', app()->getLocale()) }}" class="hover:text-blue-600">
                        {{ __('Home') }}
                    </a>
                    <a href="{{ route('posts.index', app()->getLocale()) }}" class="hover:text-blue-600">
                        {{ __('Posts') }}
                    </a>

                    <div class="flex gap-2 ml-4">
                        @foreach(['en', 'zh'] as $lang)
                            @php
                                // Получаем текущий путь БЕЗ языкового префикса
                                $currentPath = request()->path();
                                $segments = explode('/', $currentPath);

                                // Убираем первый сегмент если это язык
                                if (in_array($segments[0] ?? '', ['en', 'zh'])) {
                                    array_shift($segments);
                                }

                                // Собираем путь без языка
                                $pathWithoutLocale = implode('/', $segments);

                                // Формируем новый URL с новым языком
                                $newUrl = $pathWithoutLocale ? "/{$lang}/{$pathWithoutLocale}" : "/{$lang}";
                            @endphp
                            <a href="{{ $newUrl }}"
                            class="{{ app()->getLocale() == $lang ? 'font-bold text-blue-600' : '' }}">
                                {{ strtoupper($lang) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="items-center justify-center">
                    <a href="{{ route('home', app()->getLocale()) }}" class="text-xl font-bold">
                        {{ config('app.name') }}
                    </a>
                </div>
            </div>--}}
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="mt-8 py-4 text-center text-gray-500">
        <div class="flex justify-center items-center">
            <img
                src="/images/logo_white.png"
                alt="Loki translate"
                class="w-[45px] h-[45px]"
            >
        </div>
        <div class="mt-6 mb-6 section-tags">
            © {{ date('Y') }} {{ __('Loki Solutions Ltd. All rights reserved. Mongkok, Hong Kong') }}{{-- config('app.name') --}}
        </div>
    </footer>

    {{-- Popup --}}
    <div
        x-data
        x-show="$store.contactModal.open"
        x-on:keydown.escape.window="$store.contactModal.closeModal()"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    >
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto" @click.away="$store.contactModal.closeModal()">
            <div class="flex justify-between items-center p-6 border-b">
                <div class="text-2xl font-bold text-gray-600">{{ __('Contact Us') }}</div>
                <button @click="$store.contactModal.closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">✕</button>
            </div>

            <div x-data="contactForm()" class="p-6 space-y-4 contactus">
                <form @submit.prevent="submitForm" class="space-y-4">
                    {{-- Успех --}}
                    <div x-show="success" x-transition class="bg-green-50 text-green-700 p-4 rounded-lg text-center">
                        ✅ {{ __('Your message has been sent!') }}
                    </div>

                    {{-- Поле Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }} <span class="text-red-500">*</span></label>
                        <input
                            type="text"
                            x-model="form.name"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            :class="{ 'border-red-500': errors.name }"
                            required
                        >
                        <span x-show="errors.name" x-text="errors.name" class="text-red-500 text-sm mt-1 block"></span>
                    </div>

                    {{-- Поле Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }} <span class="text-red-500">*</span></label>
                        <input
                            type="email"
                            x-model="form.email"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none"
                            :class="{ 'border-red-500': errors.email }"
                            required
                        >
                        <span x-show="errors.email" x-text="errors.email" class="text-red-500 text-sm mt-1 block"></span>
                    </div>

                    {{-- Поле Message --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Message') }} <span class="text-red-500">*</span></label>
                        <textarea
                            x-model="form.message"
                            rows="4"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none resize-none"
                            :class="{ 'border-red-500': errors.message }"
                            required
                        ></textarea>
                        <span x-show="errors.message" x-text="errors.message" class="text-red-500 text-sm mt-1 block"></span>
                    </div>

                    {{-- Кнопка отправки --}}
                    <button
                        type="submit"
                        x-bind:disabled="sending"
                        class="contactus_btn"
                    >
                        <span x-show="!sending">{{ __('Send Message') }}</span>
                        <span x-show="sending" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                            </svg>
                            {{ __('Sending...') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>