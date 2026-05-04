<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Adient WebAPP">

	<title>@yield('title')</title>

	<link rel="canonical" href="https://app.swi.adient.com">

    <link rel="icon" href="{{ asset('adient-favicon.png') }}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<meta name="theme-color" content="#ffffff">

    @vite('resources/css/app.css')
    @stack('styles')

	<script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
		if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
			document.documentElement.classList.add('dark');
		} else {
			document.documentElement.classList.remove('dark');
		}
	</script>
</head>

<body class="bg-gray-10 dark:bg-gray-800 text-adient-teal-1">
    <header>
        <nav class="fixed z-30 w-full bg-white border-b border-gray-200 shadow-lg dark:bg-gray-800 dark:border-gray-700 py-3 px-4">
            <div class="flex justify-between items-center max-w-screen-2xl mx-auto">
                <div class="flex justify-start items-center">
                    <a href="{{ route('home') }}" class="flex ml-8 mr-14">
                        <img class="dark:hidden" src="{{ asset('adient/adn_rgb_grn_pos.png') }}" style="width:100px;" alt="Logo" />
                        <img class="hidden dark:block" src="{{ asset('adient/adn_rgb_grn_rev.png') }}" style="width:100px;" alt="Logo" />
                    </a>
                </div>
                <div class="flex justify-between items-center lg:order-2">
                    <div class="mr-3 -mb-1 hidden sm:block">
                        <span></span>
                    </div>

                    <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                        @svg('heroicon-s-sun', 'w-5 h-5 hidden text-adient-teal-1 dark:text-adient-green-1', ['id' => 'theme-toggle-light-icon'])
                        @svg('heroicon-s-moon', 'w-5 h-5 hidden text-adient-teal-1 dark:text-adient-green-1', ['id' => 'theme-toggle-dark-icon'])
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="bg-gray-200 dark:bg-gray-900">
        <div class="flex items-center justify-center pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
            <div class="relative flex items-top justify-center sm:items-center sm:pt-0">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
                        <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                            @yield('code')
                        </div>

                        <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                            @yield('status')
                        </div>
                    </div>
                    <div class="w-full mt-4 text-xs text-gray-500 uppercase tracking-wider">
                        @yield('message')
                    </div>
                    {{-- <div class="flex justify-center items-center pt-8">
                        <x-button.outline href="{{ url()->previous() }}">
                            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
                            Go Back
                        </x-button.outline>
                    </div> --}}
                </div>
            </div>
        </div>
    </main>

    @vite('resources/js/app.js')
    @stack('scripts')
</body>
</html>
