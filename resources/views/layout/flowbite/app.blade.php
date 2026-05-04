<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Adient WebAPP">

	<title>Adient WebAPP</title>

	<link rel="canonical" href="https://app.swi.adient.com">

    <link rel="icon" href="{{ asset('adient-favicon.png') }}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

	<meta name="theme-color" content="#ffffff">

    @vite('resources/css/app.css')
    @livewireStyles
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

<body class="bg-gray-100 dark:bg-gray-800 text-adient-teal-1">
    {{-- @includeIf('layout.flowbite.partials.preloader') --}}
	@includeIf('layout.flowbite.partials.header')

	<div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
		@includeIf('layout.flowbite.partials.sidebar')

        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
		<div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
			<main>
				<div class="px-4">
                    @hasSection('content')
                        @yield('content')
                    @else
                        {{ $slot ?? '' }}
                    @endif
				</div>

                @yield('drawers')
			</main>

			@includeIf('layout.flowbite.partials.footer')
		</div>
	</div>

    @livewireScripts
    @vite('resources/js/app.js')
    @stack('scripts')

    @include('sweetalert2::index')
</body>
</html>
