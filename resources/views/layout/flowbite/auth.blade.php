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

                    <button type="button" class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 flex-shrink-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="userMenuDropdownButton" aria-expanded="false" data-dropdown-toggle="userMenuDropdown">
                        <span class="sr-only">User menu</span>
                        <img src="{{ asset('images/user/user-00.jpg') }}" class="w-8 h-8 rounded-full" alt="Guest" />
                    </button>

                    <div class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600" id="userMenuDropdown" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1332px, 58px);">
                        <div class="py-3 px-4">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-white">Not Authorized User</span>
                        </div>
                        <ul class="py-1 font-light text-gray-500 dark:text-gray-400" aria-labelledby="userMenuDropdownButton">
                            <li>
                                <a href="{{ route('login') }}" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                Login
                            </a>
                            <li>
                                <a href="{{ route('login-as') }}" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-400 dark:hover:text-white">
                                Login As ...
                            </a>
                        </ul>
                        @if( Route::has('register') )
                        <ul class="py-1 font-light text-gray-500 dark:text-gray-400" aria-labelledby="dropdown">
                            <li>
                                <a href="{{ route('register') }}" class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Register
                                </a>
                            </li>
                        </ul>
                        @endif
                    </div>

                    <button type="button" id="toggleMobileMenuButton" data-collapse-toggle="toggleMobileMenu" class="items-center p-2 text-gray-500 rounded-lg md:ml-2 lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <span class="sr-only">Open menu</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
        </nav>
    </header>

    <main class="bg-gray-200 dark:bg-gray-900">
        <div class="flex items-center justify-center pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
            @yield('content')
        </div>
    </main>

    @vite('resources/js/app.js')
    @livewireScripts
    @stack('scripts')
</body>
</html>
