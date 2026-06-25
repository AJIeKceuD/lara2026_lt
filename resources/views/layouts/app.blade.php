<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
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
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn m-1">
                            {{ __('Project') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn m-1">
                            {{ __('Services') }}
                        </a>
                        <a href="{{ route('posts.index', app()->getLocale()) }}" class="black_btn m-1">
                            {{ __('Posts') }}
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
                        class="absolute top-full left-0 right-0 md:hidden bg-black shadow-lg rounded-lg p-4 z-50 flex flex-col gap-2"
                        @click.away="mobileMenuOpen = false"
                    >
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Home') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Project') }}
                        </a>
                        <a href="{{ route('home', app()->getLocale()) }}" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Services') }}
                        </a>
                        <a href="{{ route('posts.index', app()->getLocale()) }}" class="black_btn w-full text-center" @click="mobileMenuOpen = false">
                            {{ __('Posts') }}
                        </a>
                    </div>
                </div>
                <div class="flex justify-center items-center">
                    LS
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

            <!--div class="flex justify-between items-center">
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
            </div-->
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
    
    <footer class="mt-8 py-4 text-center text-gray-500">
        © {{ date('Y') }} {{ config('app.name') }}
    </footer>
</body>
</html>