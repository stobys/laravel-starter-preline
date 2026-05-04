<div x-data="{ dropdownOpen: false }" @click.outside="dropdownOpen = false" class="relative">
    <a class="flex items-center text-gray-700 dark:text-gray-400" href="#" @click.prevent="dropdownOpen = ! dropdownOpen">

        @auth
            <span class="mr-3 h-11 w-11 overflow-hidden rounded-full">
                <img src="images/user/owner.jpg" alt="User" />
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
        @auth
        <div class="text-center pb-3 border-b border-gray-200">
            <span class="text-theme-sm block font-medium text-gray-700 dark:text-gray-400">
                {{ auth()?->user()?->full_name }}
            </span>
            <span class="text-theme-xs mt-0.5 block text-gray-500 dark:text-gray-400">
                {{ auth()?->user()?->email }}
            </span>
        </div>

        <ul class="flex flex-col gap-1 border-b border-gray-200 pt-4 pb-3 dark:border-gray-800">
            <li>
                <a href="{{ route('profile.edit') }}"
                    class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                >
                    @svg('feather-user', 'w-5 h-5')
                    Edit profile
                </a>
            </li>
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

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button onclick="event.preventDefault(); this.closest('form').submit();"
                class="group w-full text-theme-sm mt-3 flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
            >
                @svg('feather-log-out', 'w-5 h-5')
                {{ __('Log Out') }}
            </button>
        </form>

        @else
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
                <li>
                    <a href="{{ route('register') }}"
                        class="group text-theme-sm flex items-center gap-3 rounded-lg px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
                    >
                        @svg('feather-user-plus', 'w-5 h-5')
                        Register
                    </a>
                </li>
            </ul>
        @endauth

    </div>
</div>
