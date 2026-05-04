<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />

        <title>Blank Page | TailAdmin - Tailwind CSS Admin Dashboard Template</title>

        <link rel="icon" href="favicon.ico">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet" />

        @vite('resources/css/app.css')
        @livewireStyles
        @stack('styles')
    </head>
    <body
        x-data="{ page: 'blank', 'loaded': true, 'darkMode': true, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': true }"
        x-init="darkMode = JSON.parse(localStorage.getItem('darkMode'));
            $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark bg-gray-900': darkMode === true}"
    >
        @includeIf('layout.partials.preloader')

        <div class="flex h-screen overflow-hidden">
            @includeIf('layout.partials.sidebar')

            <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">
                @includeIf('layout.partials.header')

                <main class="px-4 md:px-6 pt-4 md:pt-6">
                    <div class="mx-auto max-w-(--breakpoint-2xl)">
                        @hasSection('content')
                            @yield('content')
                        @else
                            {{ $slot ?? '' }}
                        @endif
                    </div>

                    <p class="my-10 p-3 text-sm text-right text-gray-500">
                        &copy; 2019-2025 <a href="https://library.app/" class="hover:underline" target="_blank">library.app</a>
                    </p>
                </main>
            </div>
        </div>

        @vite('resources/js/app.js')
        @livewireScripts
        @stack('scripts')
    </body>
</html>
