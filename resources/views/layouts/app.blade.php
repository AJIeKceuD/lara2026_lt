<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/ltls.css'])
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100">
    <nav class="shadow-md sticky top-0 z-50 bg-ltls-black">
        <div class="container mx-auto px-4 py-3">
            <div class="grid grid-cols-3 gap-4">
                <div x-data="{ mobileMenuOpen: false }" class="justify-start relative">
                    {{-- Десктопное меню --}}
                    <div class="hidden md:flex items-center justify-start gap-2">
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn m-1">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#projects" class="black_btn m-1">
                            {{ __('Projects') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#services" class="black_btn m-1">
                            {{ __('Services') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#news" class="black_btn m-1">
                            {{ __('News') }}
                        </a>
                    </div>

                    {{-- Бургер-иконка (только на мобильных) --}}
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden flex flex-col gap-1.5 p-2"
                        aria-label="Toggle menu"
                    >
                        <span class="block w-6 h-0.5 bg-ltls-white transition-transform duration-300"
                            :class="{ 'rotate-45 translate-y-2': mobileMenuOpen }"></span>
                        <span class="block w-6 h-0.5 bg-ltls-white transition-opacity duration-300"
                            :class="{ 'opacity-0': mobileMenuOpen }"></span>
                        <span class="block w-6 h-0.5 bg-ltls-white transition-transform duration-300"
                            :class="{ '-rotate-45 -translate-y-2': mobileMenuOpen }"></span>
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
                        class="absolute top-full left-0 right-0 md:hidden bg-black rounded-lg p-4 z-50 flex flex-col gap-2"
                        @click.away="mobileMenuOpen = false"
                    >
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#projects" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Project') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#services" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Services') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}#news" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('News') }}
                        </a>
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    <a href="{{ route('home', app()->getLocale()) }}">
                        <img
                            src="/images/logo_white.png"
                            alt="Loki translate"
                            class="w-[45px] h-[45px]"
                        >
                    </a>
                </div>
                <div class="ml-auto">
                    <!-- Language switcher -->
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
            © {{ date('Y') }} {{ __('LOKI SOLUTIONS LTD. ALL RIGHT RESERVED. MONGKOK, HONG KONG') }}{{-- config('app.name') --}}
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