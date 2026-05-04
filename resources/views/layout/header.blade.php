<header class="fixed top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-48 lg:z-61 w-full bg-navbar-2 text-sm py-2.5">
    <nav class="px-4 sm:px-5.5 flex basis-full items-center w-full mx-auto">
        <div class="w-full flex items-center gap-x-1.5">
            <ul class="flex items-center gap-1.5">
                <li class="inline-flex items-center gap-1 relative pe-1.5 last:pe-0 last:after:hidden after:absolute after:top-1/2 after:end-0 after:inline-block after:w-px after:h-3.5 after:bg-navbar-2-divider after:rounded-full after:-translate-y-1/2 after:rotate-12">
                    <a class="shrink-0 inline-flex justify-center items-center rounded-md text-xl inline-block font-semibold focus:outline-hidden focus:opacity-80" href="{{ url('/') }}" aria-label="Home">
                        <img src="{{ asset('img/app-logo.svg') }}" alt="Adient Logo" style="width: 80px; height: 32px;" />
                    </a>

                    <div class="hidden sm:block"></div>

					<!-- Navigation Toggle -->
					<div class="lg:hidden text-center">
						<button type="button" class="p-1.5 size-7.5 inline-flex items-center gap-x-1 text-xs rounded-md border border-transparent text-foreground hover:bg-surface-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-surface-focus" aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-header" aria-label="Toggle navigation" data-hs-overlay="#hs-sidebar-header">
							<x-feather-menu class="shrink-0 size-3.5" />
						</button>
					</div>
					<!-- End Navigation Toggle -->

                    <!-- Sidebar Toggle -->
					<button type="button" class="p-1.5 size-7.5 inline-flex items-center gap-x-1 text-xs rounded-md border border-transparent text-foreground hover:bg-surface-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-surface-focus" aria-haspopup="dialog" aria-expanded="true" aria-controls="hs-pro-sidebar" data-hs-overlay="#hs-pro-sidebar" data-hs-overlay-minifier="#hs-pro-sidebar">
						{{-- <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path><path d="m10 15-3-3 3-3"></path></svg> --}}
						<x-feather-sidebar class="shrink-0 size-3.5" />
                    	{{-- <svg class="hidden hs-overlay-minified:block shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path><path d="m8 9 3 3-3 3"></path></svg>
                    	<svg class="hs-overlay-minified:hidden shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M15 3v18"></path><path d="m10 15-3-3 3-3"></path></svg> --}}
					</button>
                    <!-- End Sidebar Toggle -->
                </li>

				@auth
                <li class="inline-flex items-center relative pe-1.5 last:pe-0 last:after:hidden after:absolute after:top-1/2 after:end-0 after:inline-block after:w-px after:h-3.5 after:bg-navbar-2-divider after:rounded-full after:-translate-y-1/2 after:rotate-12">
                    <!-- Users Dropdown -->
                    <div class="inline-flex justify-center w-full">
						<div class="hs-dropdown relative [--strategy:absolute] [--placement:bottom-left] inline-flex w-full">
							<!-- Teams Button -->
							<button id="hs-pro-antmd" type="button" class="py-1 px-2 min-h-8 flex items-center gap-x-1 font-medium text-sm text-foreground rounded-lg hover:bg-surface-hover focus:outline-hidden focus:bg-surface-focus" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
								{{ __('app.menu.header.users') }}
								<svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
							</button>
							<!-- End Teams Button -->

							<!-- Dropdown -->
							<div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-65 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-dropdown border border-dropdown-line rounded-xl shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="hs-pro-antmd">
								<div class="p-1 border-t border-dropdown-divider">
									<a href="{{ route('users.create') }}" class="w-full flex items-center gap-x-3 py-2 px-2.5 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
										<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
										{{ __('app.menu.header.add-user') }}
									</a>
									<a href="{{ route('users.index') }}" class="w-full flex items-center gap-x-3 py-2 px-2.5 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
										<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
										{{ __('app.menu.header.manage-users') }}
									</a>
								</div>
							</div>
							<!-- End Dropdown -->
						</div>
                    </div>
                    <!-- End Teams Dropdown -->
                </li>
				@endauth
            </ul>

            <ul class="flex flex-row items-center gap-x-3 ms-auto">
				@if( auth()->check() && auth()->user()->isAlmighty() )
                <li class="hidden lg:inline-flex items-center gap-1.5 relative pe-3 last:pe-0 last:after:hidden after:absolute after:top-1/2 after:end-0 after:inline-block after:w-px after:h-3.5 after:bg-navbar-2-divider after:rounded-full after:-translate-y-1/2 after:rotate-12">
                    <a href="https://www.preline.co/docs/index.html" class="flex items-center gap-x-1.5 py-1.5 px-2 text-sm text-navbar-2-nav-foreground rounded-lg hover:bg-navbar-2-nav-hover focus:outline-hidden focus:bg-navbar-2-nav-focus">
                    	<x-feather-book-open class="shrink-0 size-4 text-blue-600" /> Docs
                    </a>

                    <a href="https://www.preline.co/examples.html" class="flex items-center gap-x-1.5 py-1.5 px-2 text-sm text-navbar-2-nav-foreground rounded-lg hover:bg-navbar-2-nav-hover focus:outline-hidden focus:bg-navbar-2-nav-focus">
                    	<x-feather-book-open class="shrink-0 size-4 text-blue-600" /> Examples
                    </a>

                    <a href="https://www.preline.co/templates.html" class="flex items-center gap-x-1.5 py-1.5 px-2 text-sm text-navbar-2-nav-foreground rounded-lg hover:bg-navbar-2-nav-hover focus:outline-hidden focus:bg-navbar-2-nav-focus">
                    	<x-feather-layout class="shrink-0 size-4 text-indigo-500" /> Templates
                    </a>

                    <a href="https://www.preline.co/plugins.html" class="flex items-center gap-x-1.5 py-1.5 px-2 text-sm text-navbar-2-nav-foreground rounded-lg hover:bg-navbar-2-nav-hover focus:outline-hidden focus:bg-navbar-2-nav-focus">
                    	<x-feather-grid class="shrink-0 size-4 text-pink-600" /> Plugins
                    </a>
                </li>
				@endif

                <li class="inline-flex items-center gap-1.5 relative pe-3 last:pe-0 last:after:hidden after:absolute after:top-1/2 after:end-0 after:inline-block after:w-px after:h-3.5 after:rounded-full after:-translate-y-1/2 after:rotate-12">
                    <div class="h-8">
                        @auth
                        <!-- Language Dropdown -->
                        <div class="hs-dropdown inline-flex [--strategy:absolute] [--auto-close:inside] [--placement:bottom-right] relative text-start">
                            <button id="hs-dnad" type="button" class="p-0.5 inline-flex shrink-0 items-center gap-x-3 text-start text-navbar-nav-foreground rounded-full hover:bg-navbar-nav-hover focus:outline-hidden focus:bg-navbar-nav-focus" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
								@svg('flag-language-'.app()->getLocale(), 'size-6')
                            </button>

                            <!-- Account Dropdown -->
                            <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-dropdown border border-dropdown-line rounded-xl shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="hs-dnad">
                                <div class="p-1 border-t border-dropdown-divider">
                                    <a href="{{ route('lang.switch', 'pl') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-flag-language-pl class="shrink-0 size-5" />
                                        <span class="grow">{{ __('app.menu.header.language-pl') }}</span>
										@if( app()->getLocale() == 'pl')
											<x-feather-check class="shrink-0 size-5" />
										@endif
                                    </a>
                                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-flag-language-en class="shrink-0 size-5" />
                                        <span class="grow">{{ __('app.menu.header.language-en') }}</span>
										@if( app()->getLocale() == 'en')
											<x-feather-check class="shrink-0 size-5" />
										@endif
                                    </a>
                                    <a href="{{ route('lang.switch', 'de') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-flag-language-de class="shrink-0 size-5" />
                                        <span class="grow">{{ __('app.menu.header.language-de') }}</span>
										@if( app()->getLocale() == 'de')
											<x-feather-check class="shrink-0 size-5" />
										@endif
                                    </a>
                                </div>
                            </div>
                            <!-- End Languge Dropdown -->
                        </div>
                        @endauth
                    </div>
                </li>

                <li class="inline-flex items-center gap-1.5 relative pe-3 last:pe-0 last:after:hidden after:absolute after:top-1/2 after:end-0 after:inline-block after:w-px after:h-3.5 after:bg-navbar-2-divider after:rounded-full after:-translate-y-1/2 after:rotate-12">
                    <div class="h-8">
                        @auth
                        <!-- Language Dropdown -->
                        <div class="hs-dropdown inline-flex [--strategy:absolute] [--auto-close:inside] [--placement:bottom-right] relative text-start">
                            <button id="hs-dnad" type="button" class="p-0.5 inline-flex shrink-0 items-center gap-x-3 text-start text-navbar-nav-foreground rounded-full hover:bg-navbar-nav-hover focus:outline-hidden focus:bg-navbar-nav-focus" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                <img class="shrink-0 size-7 rounded-lg" src="{{ route('users.avatar', auth()->id()) }}" alt="{{ auth()->user()->full_name }}">
                            </button>

                            <!-- Account Dropdown -->
                            <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-60 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-dropdown border border-dropdown-line rounded-xl shadow-xl" role="menu" aria-orientation="vertical" aria-labelledby="hs-dnad">
                                <div class="py-2 px-3.5 text-end">
                                    <span class="font-medium text-foreground">
                                        {{ auth()->user()->full_name }}
                                    </span>
                                    <p class="text-sm text-muted-foreground-1">
                                        {{ auth()->user()->email }}
                                    </p>
									@if(auth()->user()->isImpersonated())
										<p class="text-sm text-muted-foreground-1">
											impersonated by {{ auth()->user()->impersonator()->full_name }}
										</p>
									@endif
                                </div>

                                <div class="px-4 py-2 border-t border-dropdown-divider">
                                    <!-- Switch/Toggle -->
                                    <div class="flex flex-wrap justify-between items-center gap-2">
                                        <span class="flex-1 cursor-pointer text-sm text-foreground">{{ __('app.menu.header.theme') }}</span>
                                        <div class="p-0.5 inline-flex cursor-pointer bg-surface rounded-full">
                                            <button type="button" class="size-7 flex justify-center items-center bg-layer shadow-sm text-layer-foreground rounded-full hs-auto-mode-active:bg-transparent hs-auto-mode-active:shadow-none hs-dark-mode-active:bg-transparent hs-dark-mode-active:shadow-none" data-hs-theme-click-value="default">
                                                <x-feather-sun class="shrink-0 size-4" />
                                                <span class="sr-only">{{ __('app.menu.header.theme-light') }}</span>
                                            </button>
                                            <button type="button" class="size-7 flex justify-center items-center text-layer-foreground rounded-full hs-dark-mode-active:bg-secondary-active hs-dark-mode-active:text-secondary-foreground hs-dark-mode-active:shadow-sm" data-hs-theme-click-value="dark">
                                                <x-feather-moon class="shrink-0 size-4" />
                                                <span class="sr-only">{{ __('app.menu.header.theme-dark') }}</span>
                                            </button>
                                            <button type="button" class="size-7 flex justify-center items-center text-layer-foreground rounded-full hs-auto-light-mode-active:bg-layer hs-auto-mode-active:shadow-sm" data-hs-theme-click-value="auto">
                                                <x-feather-monitor class="shrink-0 size-4" />
                                                <span class="sr-only">{{ __('app.menu.header.theme-system') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End Switch/Toggle -->
                                </div>

                                <div class="p-1 border-t border-dropdown-divider">
                                    <a href="{{ route('users.settings') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-feather-settings class="shrink-0 mt-0.5 size-4" />
                                        {{ __('app.menu.general.settings') }}
                                    </a>
                                    <a href="{{ route('password.change') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-feather-key class="shrink-0 mt-0.5 size-4" />
                                        {{ __('app.menu.general.change-pass') }}
                                    </a>
                                    <a href="{{ route('users.delegations.index') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-feather-users class="shrink-0 mt-0.5 size-4" />
                                        {{ __('app.menu.general.delegations') }}
                                    </a>
									@impersonating()
										<a href="{{ route('users.impersonate.leave') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
											<x-feather-users class="shrink-0 mt-0.5 size-4" />
											{{ __('users.actions.impersonate-leave') }}
										</a>
									@endImpersonating
                                    <a href="{{ route('logout') }}" class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-dropdown-item-foreground hover:bg-dropdown-item-hover disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-dropdown-item-focus">
                                        <x-feather-log-out class="shrink-0 mt-0.5 size-4" />
                                        {{ __('app.menu.general.logout') }}
                                    </a>
                                </div>
                            </div>
                            <!-- End Languge Dropdown -->

                        </div>
                        <!-- End Account Dropdown -->
                        @else
							<a class="flex items-center gap-x-1.5 py-1.5 px-2 text-sm text-navbar-2-nav-foreground rounded-lg hover:bg-navbar-2-nav-hover focus:outline-hidden focus:bg-navbar-2-nav-focus" href="{{ route('login') }}">
								<x-feather-user class="size-4" />
								{{ __('app.menu.general.login') }}
							</a>
                        @endauth
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
