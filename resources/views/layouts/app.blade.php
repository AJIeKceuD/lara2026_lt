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
    <nav class="shadow-md">
        <div class="container mx-auto px-4 py-3">
            <div class="grid grid-cols-3 gap-4">
                <div class="justify-start">
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