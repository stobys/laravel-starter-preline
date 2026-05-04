
<!-- Sidebar -->
<div id="hs-pro-sidebar" class="hs-overlay [--body-scroll:true] lg:[--overlay-backdrop:false] [--is-layout-affect:true] [--opened:lg] [--auto-close:lg] hs-overlay-open:translate-x-0 lg:hs-overlay-layout-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-60 fixed inset-y-0 z-60 start-0 bg-sidebar-2 lg:block lg:-translate-x-full lg:end-auto lg:bottom-0 open opened"
	role="dialog" aria-label="Sidebar" style="outline: none;" aria-overlay="true" tabindex="-1">

{{-- <div id="hs-pro-sidebar" class="hs-overlay [--body-scroll:true]
		bg-sidebar-2
		 [--auto-close:lg]  lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 w-60
		hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform h-full
		hidden fixed top-0 start-0 bottom-0 z-60 border-gray-200 dark:border-neutral-700
	" role="dialog" tabindex="-1" aria-label="Sidebar"> --}}

	<div class="relative flex flex-col h-full max-h-full">
		<!-- Header -->
		<header class="p-4 flex justify-between items-center gap-x-2">
			<a class="flex-none font-semibold text-xl text-gray-800 dark:text-white focus:outline-hidden focus:opacity-80" href="#" aria-label="Brand">Brand</a>

			<div class="lg:hidden -me-2">
			<!-- Close Button -->
			<button type="button" class="flex justify-center items-center gap-x-3 size-6 bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-sm text-gray-600 dark:text-neutral-300 hover:bg-gray-50 dark:hover:bg-neutral-700 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700" data-hs-overlay="#hs-sidebar-header">
				<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
				<span class="sr-only">Close</span>
			</button>
			<!-- End Close Button -->
			</div>
			<div class="@@white.header.minifyToggle.class dark:@@neutral-800.header.minifyToggle.class">
			<!-- Toggle Button -->
			<button type="button" class="flex justify-center items-center flex-none gap-x-3 size-9 text-sm text-gray-600 dark:text-neutral-300 hover:bg-gray-100 dark:hover:bg-neutral-700 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-header" aria-label="Minify navigation" data-hs-overlay-minifier="#hs-sidebar-header">
				<svg class="hidden hs-overlay-minified:block shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m8 9 3 3-3 3"/></svg>
				<svg class="hs-overlay-minified:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M15 3v18"/><path d="m10 15-3-3 3-3"/></svg>
				<span class="sr-only">Navigation Toggle</span>
			</button>
			<!-- End Toggle Button -->
			</div>
		</header>
		<!-- End Header -->

        <!-- Header -->
        @auth
        <div class="mt-auto p-2 border-y border-gray-200 dark:border-neutral-700">
            <!-- Account Dropdown -->
            <div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
                <button id="hs-sidebar-header-example-with-dropdown" type="button" class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-gray-800 dark:text-neutral-200 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                    <img class="shrink-0 size-5 rounded-full" src="{{ route('users.avatar', auth()->id()) }}" alt="{{ auth()->user()->full_name }}">
                    {{ auth()->user()->full_name }}
                    <svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                </button>

                <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-56 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-white dark:bg-neutral-900 border border-transparent rounded-lg shadow-lg" role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-header-example-with-dropdown">
                    <div class="p-1">
                        <a href="{{ route('password.change') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-800 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-800">
                            <x-feather-key class="shrink-0 size-4" />
                            {{ __('app.menu.general.change-pass') }}
                        </a>
                        <a href="{{ route('logout') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-800 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-800">
                            <x-feather-log-out class="shrink-0 size-4" />
                            {{ __('app.menu.general.logout') }}
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Account Dropdown -->
        </div>
        @endauth
        <!-- End Header -->

      <!-- Body -->
      <nav class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
        <div class="hs-accordion-group pb-0 px-2 pt-2 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
            @auth
            <x-sidebar.group title="{{ __('app.menu.sidebar.management') }}">
				@if( auth()->user()->isAlmighty() )
                <x-sidebar.item href="{{ route('security.index') }}" text="{{ __('app.menu.sidebar.security') }}" :active="request()->routeIs('security.*')">
                    <x-/heroicon-o-bug-ant class="shrink-0 size-4" />
                </x-sidebar.item>
                <x-sidebar.item href="{{ route('service.index') }}" text="{{ __('app.menu.sidebar.service') }}" :active="request()->routeIs('service.*')">
                    <x-feather-tool class="shrink-0 size-4" />
                </x-sidebar.item>
				@endif
                <x-sidebar.item href="{{ route('departments.index') }}" text="{{ __('app.menu.sidebar.departments') }}" :active="request()->routeIs('departments.*')">
                    <x-feather-layers class="shrink-0 size-4" />
                </x-sidebar.item>
                <x-sidebar.item href="{{ route('roles.index') }}" text="{{ __('app.menu.sidebar.roles') }}" :active="request()->routeIs('roles.*')">
                    <x-feather-shield class="shrink-0 size-4" />
                </x-sidebar.item>
                <x-sidebar.item href="{{ route('users.index') }}" text="{{ __('app.menu.sidebar.users') }}" :active="request()->routeIs('users.*')">
                    <x-feather-users class="shrink-0 size-4" />
                </x-sidebar.item>
            </x-sidebar.group>
            @endauth

            <x-sidebar.group title="{{ __('app.menu.sidebar.app') }}">
                <x-sidebar.item href="{{ route('dashboard.dashboard') }}" text="{{ __('app.menu.sidebar.dashboard') }}" :active="request()->routeIs('dashboard*')">
                    <x-feather-bar-chart-2 class="shrink-0 size-4" />
                </x-sidebar.item>
            </x-sidebar.group>
        </div>
      </nav>
      <!-- End Body -->

      <!-- Footer -->
        @auth
			<p class="text-[9px] text-gray-300 dark:text-gray-400 text-right pe-2">
				PHP v{{ phpversion() }} • Laravel v{{ app()->version() }}
			</p>
            <footer class="mt-auto p-2 border-t border-sidebar-divider">
                <!-- Account Dropdown -->
                <div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
                    <button id="hs-sidebar-footer-example-with-dropdown" type="button" class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-foreground rounded-md hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                        <img class="shrink-0 size-5 rounded-full" src="{{ route('users.avatar', auth()->id()) }}" alt="{{ auth()->user()->full_name }}">
                        {{ auth()->user()->full_name }}
                        <svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                    </button>

                    <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-dropdown border border-dropdown-line rounded-lg shadow-lg" role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-footer-example-with-dropdown">
                        <div class="p-1">
                            <a href="{{ route('password.change') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus">
                                <x-feather-key class="shrink-0 size-4" />
                                {{ __('app.menu.general.change-pass') }}
                            </a>
                            <a href="{{ route('logout') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus">
                                <x-feather-log-out class="shrink-0 size-4" />
                                {{ __('app.menu.general.logout') }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Account Dropdown -->
            </footer>
        @endauth
      <!-- End Footer -->
  </div>
</div>
<!-- End Sidebar -->
