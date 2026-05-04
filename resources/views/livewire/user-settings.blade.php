<div>
    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4">
        <div class="mb-4 col-span-full xl:mb-2">
			<!-- Tab Nav -->
			<div class="border-b border-gray-200 dark:border-neutral-700">
				<nav id="hs-tabs" class="flex gap-x-2" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
					<button type="button" role="tab" id="tabs-with-underline-item-3"
						wire:click="setActiveTab('tabs-with-underline-3')"
						aria-selected="{{ ($activeTab === 'tabs-with-underline-3') ? 'true' : 'false' }}" aria-controls="tabs-with-underline-3"
						@class(['px-4 py-4 relative inline-flex items-center gap-x-2 text-sm whitespace-nowrap after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5',
							'focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none',
							'text-neutral-400 hover:text-company-teal dark:hover:text-company-green'  => $activeTab !== 'tabs-with-underline-3',
							'font-semibold after:bg-company-teal text-company-teal dark:text-company-green after:bg-company-green dark:after:bg-company-green active' => $activeTab === 'tabs-with-underline-3'
						])
					>
						<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
						Tab 1
					</button>
					<button type="button" role="tab" id="tabs-with-underline-item-2"
						wire:click="setActiveTab('tabs-with-underline-2')"
						aria-selected="{{ ($activeTab === 'tabs-with-underline-2') ? 'true' : 'false' }}" aria-controls="tabs-with-underline-2"
						@class(['px-4 py-4 relative inline-flex items-center gap-x-2 text-sm whitespace-nowrap after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5',
							'focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none',
							'text-neutral-400 hover:text-company-teal dark:hover:text-company-green'  => $activeTab !== 'tabs-with-underline-2',
							'font-semibold after:bg-company-teal text-company-teal dark:text-company-green after:bg-company-green dark:after:bg-company-green active' => $activeTab === 'tabs-with-underline-2'
						])
					>
						<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
						User Profile
					</button>
					<button type="button" role="tab" id="tabs-settings-notifications-tab"
						wire:click="setActiveTab('tabs-settings-notifications-content')"
						aria-selected="{{ ($activeTab === 'tabs-settings-notifications-content') ? 'true' : 'false' }}" aria-controls="tabs-settings-notifications-content"
						@class(['px-4 py-4 relative inline-flex items-center gap-x-2 text-sm whitespace-nowrap after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5',
							'focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none',
							'text-neutral-400 hover:text-company-teal dark:hover:text-company-green'  => $activeTab !== 'tabs-settings-notifications-content',
							'font-semibold after:bg-company-teal text-company-teal dark:text-company-green after:bg-company-green dark:after:bg-company-green active' => $activeTab === 'tabs-settings-notifications-content'
						])
					>
						<x-feather-bell class="shrink-0 size-4" />
						{{ __('settings.labels.tab-notifications') }}
					</button>
				</nav>
			</div>
			<!-- End Tab Nav -->

			<!-- Tab Nav -->
			<div class="border-b border-gray-200 dark:border-neutral-700">
				{{-- <nav id="hs-tabs" class="flex gap-x-2" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
					<button type="button" role="tab" id="tabs-with-underline-item-3"
						data-hs-tab="#tabs-with-underline-3" aria-selected="true" aria-controls="tabs-with-underline-3"
						class="px-4 hs-tab-active:font-semibold hs-tab-active:text-company-teal dark:hs-tab-active:text-company-green hs-tab-active:after:bg-company-teal dark:hs-tab-active:after:bg-company-green relative py-4 px-1 inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-gray-500 dark:text-neutral-400 after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5 after:bg-transparent hover:text-blue-700 dark:hover:text-blue-600 focus:outline-hidden focus:text-blue-700 dark:focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none active"
					>
						<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
						Tab 1
					</button>
					<button type="button" role="tab" id="tabs-with-underline-item-2"
						data-hs-tab="#tabs-with-underline-2" aria-selected="false" aria-controls="tabs-with-underline-2"
						class="px-4 hs-tab-active:font-semibold hs-tab-active:text-blue-700 dark:hs-tab-active:text-blue-600 hs-tab-active:after:bg-blue-700 dark:hs-tab-active:after:bg-blue-600 relative py-4 px-1 inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-gray-500 dark:text-neutral-400 after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5 after:bg-transparent hover:text-blue-700 dark:hover:text-blue-600 focus:outline-hidden focus:text-blue-700 dark:focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
					>
						<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="10" r="3"/><path d="M7 20.662V19a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1.662"/></svg>
						User Profile
					</button>
					<button type="button" role="tab" id="tabs-settings-notifications-tab"
						data-hs-tab="#tabs-settings-notifications-content" aria-selected="false" aria-controls="tabs-settings-notifications-content"
						class="px-4 hs-tab-active:font-semibold hs-tab-active:text-blue-700 dark:hs-tab-active:text-blue-600 hs-tab-active:after:bg-blue-700 dark:hs-tab-active:after:bg-blue-600 relative py-4 px-1 inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-gray-500 dark:text-neutral-400 after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5 after:bg-transparent hover:text-blue-700 dark:hover:text-blue-600 focus:outline-hidden focus:text-blue-700 dark:focus:text-blue-600 disabled:opacity-50 disabled:pointer-events-none"
					>
						<x-feather-bell class="shrink-0 size-4" />
						{{ __('settings.labels.tab-notifications') }}
					</button>
				</nav> --}}
			</div>
			<!-- End Tab Nav -->

			<!-- Tab Content -->
			<div class="mt-3 py-2.5">
				<div id="tabs-with-underline-3" @class(['hidden' => ($activeTab !== 'tabs-with-underline-3')]) role="tabpanel" aria-labelledby="tabs-with-underline-item-3">
					<div class="col-span-2">
						<div class="p-4 mb-4 border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6">
							<h3 class="mb-4 text-xl font-semibold dark:text-white">General information</h3>
							<form action="#">
								<div class="grid grid-cols-6 gap-6">
									<div class="col-span-6 sm:col-span-3">
										<label for="first-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First Name</label>
										<input type="text" name="first-name" id="first-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
											value="{{ auth()->user()->first_name }}" readonly required=""
										>
									</div>
									<div class="col-span-6 sm:col-span-3">
										<label for="last-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
										<input type="text" name="last-name" id="last-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
											value="{{ auth()->user()->last_name }}" readonly required=""
										>
									</div>
									<div class="col-span-6 sm:col-span-3">
										<label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
										<input type="email" name="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
											value="{{ auth()->user()->email }}" readonly required=""
										>
									</div>
									<div class="col-span-6 sm:col-span-3">
										<label for="department" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
										<input type="text" name="department" id="department" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
											value="{{ auth()->user()->department?->name }}" readonly required=""
										>
									</div>
									<div class="col-span-6 sm:col-full">
										<button class="text-white bg-green-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Save all</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div id="tabs-with-underline-2" @class(['hidden' => ($activeTab !== 'tabs-with-underline-2')]) role="tabpanel" aria-labelledby="tabs-with-underline-item-2">
					<div class="col-span-full xl:col-auto">
						<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
							<div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
								<img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green-2x.png" alt="Jese picture">
								<div>
									<h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Profile picture</h3>
									<div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
										JPG, GIF or PNG. Max size of 800K
									</div>
									<div class="flex items-center space-x-4">
										<button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
											<svg class="size-4 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 13a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 13H11V9.413l1.293 1.293a1 1 0 001.414-1.414l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13H5.5z"></path><path d="M9 13h2v5a1 1 0 11-2 0v-5z"></path></svg>
											Upload picture
										</button>
										<button type="button" class="py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
											Delete
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
							<h3 class="mb-4 text-xl font-semibold dark:text-white">Language &amp; Time</h3>
							<div class="mb-4">
								<label for="settings-language" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select language</label>
								<select id="settings-language" name="countries" class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
									@foreach ($availableLanguages as $code => $name)
										<option value="{{ $code }}">{{ $name }}</option>
									@endforeach
								</select>
							</div>
							<div class="mb-6">
								<label for="settings-timezone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time Zone</label>
								<select id="settings-timezone" name="countries" class="bg-gray-50 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
									<option>GMT+0 Greenwich Mean Time (GMT)</option>
									<option>GMT+1 Central European Time (CET)</option>
									<option>GMT+2 Eastern European Time (EET)</option>
									<option>GMT+3 Moscow Time (MSK)</option>
									<option>GMT+5 Pakistan Standard Time (PKT)</option>
									<option>GMT+8 China Standard Time (CST)</option>
									<option>GMT+10 Eastern Australia Standard Time (AEST)</option>
								</select>
							</div>
							<div>
								<button class="text-white bg-green-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save all</button>
							</div>
						</div>

						<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
							<h3 class="mb-4 text-xl font-semibold dark:text-white">Password information</h3>
							<form action="#">
								<div class="grid grid-cols-6 gap-6">
									<div class="col-span-6 sm:col-span-3">
										<label for="current-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current password</label>
										<input type="text" name="current-password" id="current-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="••••••••" required="">
									</div>
									<div class="col-span-6 sm:col-span-3">
										<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New password</label>
										<input data-popover-target="popover-password" data-popover-placement="bottom" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="••••••••" required="">
										<div data-popover="" id="popover-password" role="tooltip" class="absolute z-10 inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 opacity-0 invisible" data-popper-placement="bottom" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate3d(894.4px, 984px, 0px);">
											<div class="p-3 space-y-2">
												<h3 class="font-semibold text-gray-900 dark:text-white">Must have at least 6 characters</h3>
												<div class="grid grid-cols-4 gap-2">
													<div class="h-1 bg-orange-300 dark:bg-orange-400"></div>
													<div class="h-1 bg-orange-300 dark:bg-orange-400"></div>
													<div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
													<div class="h-1 bg-gray-200 dark:bg-gray-600"></div>
												</div>
												<p>It’s better to have:</p>
												<ul>
													<li class="flex items-center mb-1">
														<svg class="w-4 h-4 mr-2 text-green-400 dark:text-green-500" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
														Upper &amp; lower case letters
													</li>
													<li class="flex items-center mb-1">
														<svg class="w-4 h-4 mr-2 text-gray-300 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
														A symbol (#$&amp;)
													</li>
													<li class="flex items-center">
														<svg class="w-4 h-4 mr-2 text-gray-300 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
														A longer password (min. 12 chars.)
													</li>
												</ul>
										</div>
										<div data-popper-arrow="" style="position: absolute; left: 0px; transform: translate3d(139.2px, 0px, 0px);"></div>
										</div>
									</div>
									<div class="col-span-6 sm:col-span-3">
										<label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
										<input type="text" name="confirm-password" id="confirm-password" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="••••••••" required="">
									</div>
									<div class="col-span-6 sm:col-full">
										<button class="text-white bg-green-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" type="submit">Save all</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div id="tabs-settings-notifications-content" @class(['hidden' => ($activeTab !== 'tabs-settings-notifications-content')]) role="tabpanel" aria-labelledby="tabs-settings-notifications-tab">
					@includeIf('livewire.settings.notifications')
					{{-- <div class="grid grid-cols-1 px-4 xl:grid-cols-2 xl:gap-4">
						<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
							<div class="flow-root">
								<h3 class="text-xl font-semibold dark:text-white">Alerts &amp; Notifications</h3>
								<p class="text-sm font-normal text-gray-500 dark:text-gray-400">You can set up Themesberg to get notifications</p>
								<div class="divide-y divide-gray-200 dark:divide-gray-700">
									<!-- Item 1 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Company News</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Get Themesberg news, announcements, and product updates</div>
										</div>
										<label for="company-news" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="company-news" class="sr-only">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 2 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Account Activity</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Get important notifications about you or activity you've missed</div>
										</div>
										<label for="account-activity" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="account-activity" class="sr-only" checked="">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 3 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Meetups Near You</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Get an email when a Dribbble Meetup is posted close to my location</div>
										</div>
										<label for="meetups" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="meetups" class="sr-only" checked="">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 4 -->
									<div class="flex items-center justify-between pt-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">New Messages</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Get Themsberg news, announcements, and product updates</div>
										</div>
										<label for="new-messages" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="new-messages" class="sr-only">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
								</div>
								<div class="mt-6">
									<button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save all</button>
								</div>
							</div>
						</div>
						<div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800 xl:mb-0">
							<div class="flow-root">
								<h3 class="text-xl font-semibold dark:text-white">Email Notifications</h3>
								<p class="text-sm font-normal text-gray-500 dark:text-gray-400">You can set up Themesberg to get email notifications </p>
								<div class="divide-y divide-gray-200 dark:divide-gray-700">
									<!-- Item 1 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Rating reminders</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Send an email reminding me to rate an item a week after purchase</div>
										</div>
										<label for="rating-reminders" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="rating-reminders" class="sr-only">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 2 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Item update notifications</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Send user and product notifications for you</div>
										</div>
										<label for="item-update" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="item-update" class="sr-only" checked="">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 3 -->
									<div class="flex items-center justify-between py-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Item comment notifications</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Send me an email when someone comments on one of my items</div>
										</div>
										<label for="item-comment" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="item-comment" class="sr-only" checked="">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
									<!-- Item 4 -->
									<div class="flex items-center justify-between pt-4">
										<div class="flex flex-col flex-grow">
											<div class="text-lg font-semibold text-gray-900 dark:text-white">Buyer review notifications</div>
											<div class="text-base font-normal text-gray-500 dark:text-gray-400">Send me an email when someone leaves a review with their rating</div>
										</div>
										<label for="buyer-rev" class="relative flex items-center cursor-pointer">
											<input type="checkbox" id="buyer-rev" class="sr-only">
											<span class="h-6 bg-gray-200 border border-gray-200 rounded-full w-11 toggle-bg dark:bg-gray-700 dark:border-gray-600"></span>
										</label>
									</div>
								</div>
								<div class="mt-6">
									<button class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Save all</button>
								</div>
							</div>
						</div>
					</div> --}}

				</div>
			</div>
			<!-- End Tab Content -->
        </div>
        <!-- Right Content -->
    </div>

</div>
