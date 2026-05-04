<aside id="sidebar" class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width" aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <li>
                        <form action="#" method="GET" class="lg:hidden">
                            <label for="mobile-search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" name="email" id="mobile-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-200 dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
                            </div>
                        </form>
                    </li>

                    @auth
                        <x-sidebar.item href="{{ route('dashboard') }}" :selected="request()->routeIs('dashboard')">
                            <x-slot name="icon">
                                @svg('heroicon-o-presentation-chart-bar', 'w-6 h-6')
                            </x-slot>
                            {{ __('Dashboard') }}
                        </x-sidebar.item>

                        <x-sidebar.item href="{{ route('departments.index') }}" :selected="request()->routeIs('departments.index')">
                            <x-slot name="icon">
                                @svg('heroicon-o-users', 'w-6 h-6')
                            </x-slot>
                            {{ __('Departments') }}
                        </x-sidebar.item>

                        <x-sidebar.item href="{{ route('trainings.index') }}" :selected="request()->routeIs('trainings.*')">
                            <x-slot name="icon">
                                @svg('heroicon-o-academic-cap', 'w-6 h-6')
                            </x-slot>
                            {{ __('Trainings') }}
                        </x-sidebar.item>

                        <x-sidebar.item href="{{ route('training_providers.index') }}" :selected="request()->routeIs('training_providers.index')">
                            <x-slot name="icon">
                                @svg('heroicon-o-academic-cap', 'w-6 h-6')
                            </x-slot>
                            {{ __('Trainings Providers') }}
                        </x-sidebar.item>

                        @canAny(['rbac:manage-roles', 'rbac:manage-users'])
                            <x-sidebar.separator />
                            <x-sidebar.group text="Access Control" :selected="request()->routeIs('rbac.*')">
                                <x-slot name="icon">
                                    @svg('heroicon-o-shield-exclamation', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                @can('rbac:manage-roles')
                                <x-sidebar.item href="{{ route('rbac.permissions') }}" :selected="request()->routeIs('rbac.permissions')">
                                    {{ __('Permissions') }}
                                </x-sidebar.item>
                                <x-sidebar.item href="{{ route('rbac.roles') }}" :selected="request()->routeIs('rbac.roles')">
                                    {{ __('Roles') }}
                                </x-sidebar.item>
                                @endcan
                                @can('rbac:manage-users')
                                <x-sidebar.item href="{{ route('rbac.users') }}" :selected="request()->routeIs('rbac.users')">
                                    {{ __('Users') }}
                                </x-sidebar.item>
                                @endcan
                            </x-sidebar.group>
                        @endcanAny

                        @if( Route::has('settings.edit') )
                        <x-sidebar.item href="{{ route('settings.edit') }}" :selected="request()->routeIs('settings.edit')">
                            <x-slot name="icon">
                                @svg('heroicon-o-cog-6-tooth', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                            </x-slot>
                            {{ __('Settings') }}
                        </x-sidebar.item>
                        @endif
                    @endauth

                    @if(auth()->user()?->hasRole('almighty'))
                    <x-sidebar.separator />

                    @env(['local', 'dev'])
                        <x-sidebar.group text="Vercel APP">
                            <x-slot name="icon">
                                @svg('heroicon-o-shield-exclamation', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                            </x-slot>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/">
                                <x-slot name="icon">
                                    @svg('heroicon-o-presentation-chart-bar', 'w-6 h-6')
                                </x-slot>
                                Dashboard - Vercel
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/layouts/stacked/">
                                <x-slot name="icon">
                                    @svg('feather-layout', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Layout Stacked
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/layouts/sidebar/">
                                <x-slot name="icon">
                                    @svg('feather-layout', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Layout Sidebar
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/crud/products/">
                                <x-slot name="icon">
                                    @svg('heroicon-s-table-cells', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Products
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/crud/users/">
                                <x-slot name="icon">
                                    @svg('heroicon-s-table-cells', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Users
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/pages/pricing/">
                                Page / Pricing
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/pages/maintenance/">
                                Page / Maintenance
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/pages/404/">
                                Page / 404 not found
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/pages/500/">
                                Page / 500 server error
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/playground/stacked/">
                                Playground Stacked
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/playground/sidebar/">
                                Playground Sidebar
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/authentication/sign-in/">
                                Auth - Login
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/authentication/sign-up/">
                                Auth - Register
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/authentication/forgot-password/">
                                Auth - Forgot Pass
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/authentication/reset-password/">
                                Auth - Reset Pass
                            </x-sidebar.item>

                            <x-sidebar.item href="https://flowbite-admin-dashboard.vercel.app/authentication/profile-lock/">
                                Auth - Profile Lock
                            </x-sidebar.item>
                        </x-sidebar.group>

                        <x-sidebar.group text="Flowbite">
                            <x-sidebar.item href="https://flowbite.com/application-ui/demo/">
                                <x-slot name="icon">
                                    @svg('heroicon-o-rocket-launch', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                View Pro Version
                            </x-sidebar.item>
                            <x-sidebar.item href="https://github.com/themesberg/flowbite-admin-dashboard">
                                <x-slot name="icon">
                                    @svg('feather-github', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                GitHub Repository
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite.com/docs/getting-started/introduction/">
                                <x-slot name="icon">
                                    @svg('heroicon-o-document-text', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Flowbite Docs
                            </x-sidebar.item>
                            <x-sidebar.item href="https://flowbite.com/docs/components/alerts/">
                                <x-slot name="icon">
                                    @svg('heroicon-o-puzzle-piece', 'flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white')
                                </x-slot>
                                Components
                            </x-sidebar.item>
                        @endenv
                    </x-sidebar.group>
                    @endif
                </ul>

                <div class="pt-2 space-y-2"></div>
            </div>
        </div>

        @auth
            <div class="absolute bottom-0 left-0 justify-center hidden w-full p-4 space-x-4 bg-white lg:flex dark:bg-gray-800" sidebar-bottom-menu>
                <a href="#" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011 1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path></svg>
                </a>
                @if( Route::has('settings.edit') )
                <a href="{{ route('settings.edit') }}" data-tooltip-target="tooltip-settings" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                </a>
                @endif
                <div id="tooltip-settings" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Settings page
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
                <button type="button" data-dropdown-toggle="language-dropdown" class="inline-flex justify-center p-2 text-gray-500 rounded cursor-pointer hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
                    <x-icon name="flag-language-{{ app()->getLocale() }}" class="h-5 w-5 rounded-lg mt-0.5" />
                </button>

                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700" id="language-dropdown">
                    <ul class="py-1" role="none">
                        @foreach ($availableLanguages as $code => $name)
                            <li>
                                <a href="{{ route('lang.switch', $code) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white" role="menuitem">
                                    <div class="inline-flex items-center">
                                        <x-icon name="flag-language-{{ $code }}" class="w-5 h-5 rounded mr-2" />
                                        {{ $name }}
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endauth
    </div>
</aside>
