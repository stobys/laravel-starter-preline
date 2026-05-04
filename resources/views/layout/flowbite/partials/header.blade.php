<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar" class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg id="toggleSidebarMobileHamburger" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    <svg id="toggleSidebarMobileClose" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <a href="{{ url('/') }}" class="flex ml-8">
                    <p class="text-2xl font-bold">
                        <span class="text-adient-teal-1 dark:text-adient-green-1">H</span>
                        <span class="text-adient-green-1 dark:text-adient-teal-1">e</span>
                        <span class="text-adient-teal-1 dark:text-adient-green-1">R</span>
                        <span class="text-adient-teal-1 dark:text-adient-green-1">M</span>
                        <span class="text-adient-green-1 dark:text-adient-teal-1">e</span>
                        <span class="text-adient-teal-1 dark:text-adient-green-1">S</span>
                    </p>
                </a>
            </div>

            <div class="flex items-center">
                <form action="#" method="GET" class="hidden lg:block lg:pl-3.5">
                    <label for="topbar-search" class="sr-only">Search</label>
                    <div class="relative mt-1 mr-2 lg:w-96">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                        </div>
                        <input type="text" name="email" id="topbar-search" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="{{ __('app.placeholder.search') }}">
                    </div>
                </form>

                <button id="toggleSidebarMobileSearch" type="button" class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <span class="sr-only">Search</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                </button>

                @auth
                    <button type="button" data-dropdown-toggle="notification-dropdown" class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                        <span class="sr-only">View notifications</span>
                        @svg('heroicon-s-bell', 'w-6 h-6 text-adient-teal-1 dark:text-adient-green-1')
                    </button>
                    <div class="z-20 z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700" id="notification-dropdown">
                        <div class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            {{ __('notifications.labels.notifications') }}
                        </div>
                        <div>
                            <a href="#" class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11" src="https://flowbite-admin-dashboard.vercel.app/images/users/jese-leos.png" alt="Jese image">
                                    <div class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 bg-gray-900 border border-white rounded-full dark:border-gray-700">
                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
                                        <span class="font-semibold text-gray-900 dark:text-white">Jese leos</span>
                                        and <span class="font-medium text-gray-900 dark:text-white">5 others</span>
                                        started following you.
                                    </div>
                                    <div class="text-xs font-medium text-primary-700 dark:text-primary-400">10 minutes ago</div>
                                </div>
                            </a>
                        </div>
                        <a href="{{ route('notifications.index') }}" class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
                            <div class="inline-flex items-center ">
                                @svg('heroicon-s-eye', 'w-5 h-5 mr-2')
                                {{ __('notifications.labels.view_all') }}
                            </div>
                        </a>
                    </div>

                    <button type="button" data-dropdown-toggle="apps-dropdown" class="hidden p-2 text-gray-500 rounded-lg sm:flex hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700">
                        <span class="sr-only">Apps</span>
                        @svg('heroicon-s-squares-2x2', 'w-6 h-6 text-adient-teal-1 dark:text-adient-green-1')
                    </button>

                    <div class="z-20 z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:bg-gray-700 dark:divide-gray-600" id="apps-dropdown">
                        <div class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            Apps
                        </div>
                        <div class="grid grid-cols-3 gap-4 p-4">
                            <a href="#" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Sales</div>
                            </a>
                            <a href="{{ route('users.index') }}" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Users</div>
                            </a>
                            <a href="#" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v7h-2l-1 2H8l-1-2H5V5z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Inbox</div>
                            </a>
                            <a href="#" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Profile</div>
                            </a>
                            @if( Route::has('settings.edit') )
                            <a href="{{ route('settings.edit') }}" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Settings</div>
                            </a>
                            @endif
                            <a href="{{ route('trainings.index') }}" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                @svg('heroicon-s-academic-cap', 'w-7 h-7 mx-auto mb-1 text-gray-500 dark:text-gray-400')
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Trainings</div>
                            </a>
                            <a href="#" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Pricing</div>
                            </a>
                            <a href="#" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM12.5 10a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Billing</div>
                            </a>
                            <a href="{{ route('forced-logout') }}" class="block p-4 text-center rounded-lg hover:bg-gray-100 dark:hover:bg-gray-600">
                                <svg class="mx-auto mb-1 text-gray-500 w-7 h-7 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">Logout</div>
                            </a>
                        </div>
                    </div>
                @endauth

                <button id="theme-toggle" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-sm p-2.5">
                    @svg('heroicon-s-sun', 'w-5 h-5 hidden text-adient-teal-1 dark:text-adient-green-1', ['id' => 'theme-toggle-light-icon'])
                    @svg('heroicon-s-moon', 'w-5 h-5 hidden text-adient-teal-1 dark:text-adient-green-1', ['id' => 'theme-toggle-dark-icon'])
                </button>

                <div class="flex items-center ml-3">
                    <div>
                        <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                            <span class="sr-only">Open user menu</span>
                            @auth
                                <img src="{{ asset('images/user/user.png') }}" class="w-8 h-8 rounded-full" alt="User" />
                            @else
                                <img src="{{ asset('images/user/user-00.jpg') }}" class="w-8 h-8 rounded-full" alt="User" />
                            @endauth
                        </button>
                    </div>

                    <div class="z-50 hidden mr-20 shadow-lg text-base list-none divide-y divide-gray-100 rounded-lg border border-gray-300 dard:border-gray-700 bg-white dark:bg-gray-700 dark:divide-gray-600" id="dropdown-2">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-gray-300" role="none">
                                @auth
                                    {{ auth()?->user()?->full_name }}
                                @else
                                    Guest User
                                @endauth
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                @auth
                                    {{ auth()?->user()?->email }}
                                    <br />
                                    {{ auth()?->user()?->username }}
                                @endauth
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            @auth
                                <li>
                                    <a href="{{ route('dashboard') }}" class="flex items-center  px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-o-presentation-chart-bar', 'w-5 h-5 mr-2')
                                        {{ __('Dashboard') }}
                                    </a>
                                </li>
                                @if( Route::has('profile.edit') )
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-o-user-circle', 'w-5 h-5 mr-2')
                                        {{ __('Edit profile') }}
                                    </a>
                                </li>
                                @endif
                                @if( Route::has('settings.edit') )
                                <li>
                                    <a href="{{ route('settings.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-o-cog-6-tooth', 'w-5 h-5 mr-2')
                                        {{ __('Settings') }}
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <hr class="my-1" />
                                </li>
                                <li>
                                    <a href="{{ route('forced-logout') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-s-arrow-right-on-rectangle', 'w-5 h-5 mr-2')
                                        {{ __('Log out') }}
                                    </a>
                                </li>
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <button onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="group w-full text-theme-sm mt-3 flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                                    >
                                        @svg('feather-log-out', 'w-5 h-5')
                                        {{ __('Log out') }}
                                    </button>
                                </form>
                            @else
                                <li>
                                    <a href="{{ route('login') }}" class="flex items-center  px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-o-arrow-right-end-on-rectangle', 'w-5 h-5 mr-2')
                                        {{ __('Login') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('login-as') }}" class="flex items-center  px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('heroicon-s-arrow-right-end-on-rectangle', 'w-5 h-5 mr-2')
                                        {{ __('Login As ...') }}
                                    </a>
                                </li>
                                @if( Route::has('register') )
                                <li>
                                    <a href="{{ route('register') }}" class="flex items-center  px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                        @svg('feather-user-plus', 'w-5 h-5 mr-2')
                                        Register
                                    </a>
                                </li>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<div x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" class="relative">
    <a class="flex items-center text-gray-700 dark:text-gray-400" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">

        @auth
            <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                <img src="images/user/user.png" alt="User" />
            </span>

            <span class="text-theme-sm mr-1 block font-medium">
                {{ auth()?->user()?->full_name }}
            </span>
        @else
            <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                <img src="images/user/user-00.jpg" alt="User" />
            </span>

            <span class="text-theme-sm mr-1 block font-medium">Guest User</span>
        @endauth

        <svg :class="dropdownOpen && 'rotate-180'" class="stroke-gray-500 dark:stroke-gray-400" width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4.3125 8.65625L9 13.3437L13.6875 8.65625" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </a>

    <!-- Dropdown Start -->
    <div x-show="dropdownOpen" class="shadow-theme-lg dark:bg-gray-dark absolute right-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 dark:border-gray-800">
        <div class="text-center pb-3 border-b border-gray-200">
            <span class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                {{ auth()?->user()?->full_name }}
            </span>
            <span class="text-theme-xs mt-0.5 block text-gray-500 dark:text-gray-400">
                {{ auth()?->user()?->email }}
            </span>
        </div>
        @guest
            <ul class="flex flex-col gap-1 pt-4 pb-3">
                <li>
                    <a href="{{ route('login-as') }}"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-log-in', 'w-5 h-5')
                        Log in as ..
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-log-in', 'w-5 h-5')
                        Log in
                    </a>
                </li>
                @if( Route::has('register') )
                <li>
                    <a href="{{ route('register') }}"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-user-plus', 'w-5 h-5')
                        Register
                    </a>
                </li>
                @endif
            </ul>
        @else
            <ul class="flex flex-col gap-1 border-b border-gray-200 pt-4 pb-3 dark:border-gray-800">
                @if( Route::has('settings.edit') )
                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-user', 'w-5 h-5')
                        Edit profile
                    </a>
                </li>
                @endif
                <li>
                    <a href="messages.html"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-settings', 'w-5 h-5')
                        Account settings
                    </a>
                </li>
                <li>
                    <a href="settings.html"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-info', 'w-5 h-5')
                        Support
                    </a>
                </li>
            </ul>
        @endguest

    </div>
</div>
