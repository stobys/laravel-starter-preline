<div class="w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
        <div class="md:col-span-2">
            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <x-form.field-group for="username" name="username" label="{{ __('users.th.username') }}">
                    <x-form.input required id="username" name="username" value="{{ old('username', $user->username ?? null) }}"
						:readonly="$user->is_domain_user || $action == 'show'"
					/>
                </x-form.field-group>

                <x-form.field-group for="email" name="email" label="{{ __('users.th.email') }}">
                    <x-form.input type="email" required id="email" name="email" value="{{ old('email', $user->email ?? null) }}"
						:readonly="$user->is_domain_user || $action == 'show'"
					/>
                </x-form.field-group>
            </div>
            <!-- End Grid -->

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <x-form.field-group for="first_name" name="first_name" label="{{ __('users.th.first-name') }}">
                    <x-form.input required id="first_name" name="first_name" value="{{ old('first_name', $user->first_name ?? null) }}"
						:readonly="$user->is_domain_user || $action == 'show'"
					/>
                </x-form.field-group>
                <x-form.field-group for="last_name" name="last_name" label="{{ __('users.th.last-name') }}">
                    <x-form.input required id="last_name" name="last_name" value="{{ old('last_name', $user->last_name ?? null) }}"
						:readonly="$user->is_domain_user || $action == 'show'"
					/>
                </x-form.field-group>
            </div>
            <!-- End Grid -->

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
                <x-form.field-group for="department_id" name="department_id" label="{{ __('users.th.department') }}">
					<!-- Select -->
					<select name="department_id" id="hs-participants-search" data-hs-select='{
						"hasSearch": true,
						"searchPlaceholder": "Search...",
						"searchClasses": "block w-full sm:text-sm bg-transparent border-layer-line rounded-lg text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus before:absolute before:inset-0 before:z-1 py-1.5 sm:py-2 px-3",
						"searchWrapperClasses": "bg-select p-2 -mx-1 sticky top-0",
						"placeholder": "Select department ...",
						"toggleTag": "<button type=\"button\" aria-expanded=\"false\"><span class=\"me-2\" data-icon></span><span class=\"text-foreground\" data-title></span></button>",
						"toggleClasses": "hs-select-disabled:pointer-events-none hs-select-disabled:opacity-50 relative py-3 ps-4 pe-9 flex text-nowrap w-full cursor-pointer bg-layer border border-layer-line text-layer-foreground rounded-lg text-start text-sm hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus",
						"dropdownClasses": "mt-2 max-h-72 pb-1 px-1 space-y-0.5 z-20 w-full bg-select border border-select-line rounded-lg shadow-xl overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb",
						"optionClasses": "hs-selected:bg-select-item-active py-2 px-4 w-full text-sm text-select-item-foreground cursor-pointer hover:bg-select-item-hover rounded-lg focus:outline-hidden focus:bg-select-item-focus",
						"optionTemplate": "<div><div class=\"flex items-center\"><div class=\"me-2\" data-icon></div><div class=\"text-foreground\" data-title></div></div></div>",
						"extraMarkup": "<div class=\"absolute top-1/2 end-3 -translate-y-1/2\"><svg class=\"shrink-0 size-3.5 text-muted-foreground-1\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"m7 15 5 5 5-5\"/><path d=\"m7 9 5-5 5 5\"/></svg></div>"
						}' class="hidden"
						@disabled($action == 'show')
					>
						<option value="">Choose</option>
						@foreach($departments as $department)
							<option value="{{ $department->id }}" @selected($user->department_id == $department->id) data-hs-select-option='{}'>
								{{ $department->name }} ({{ $department->teta_mpk_code }})
							</option>
						@endforeach
					</select>
					<!-- End Select -->
                </x-form.field-group>
            </div>
            <!-- End Grid -->

			@unless($user->is_domain_user || $action == 'show')
				<div class="py-3 flex items-center text-sm text-gray-800 before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-white dark:before:border-neutral-600 dark:after:border-neutral-600">
					{{ __('users.labels.password-divider') }}
				</div>

				<!-- Grid -->
				<div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">
					<x-form.field-group for="password" name="password" label="{{ __('users.th.password') }}">
						<x-form.input type="password" id="password" name="password" value="{{ old('password') }}" />
					</x-form.field-group>

					<x-form.field-group for="password_confirmation" name="password_confirmation" label="{{ __('users.th.password-confirmation') }}">
						<x-form.input type="password" id="password_confirmation" name="password_confirmation" />
					</x-form.field-group>
				</div>
				<!-- End Grid -->
			@endunless

            <!-- Grid -->
            {{-- <div>
                <label for="hs-about-contacts-1" class="block mb-2 text-sm text-gray-800 dark:text-neutral-200 font-medium">Details</label>
                <textarea id="hs-about-contacts-1" name="hs-about-contacts-1" rows="4" class="py-2.5 sm:py-3 px-4 block w-full bg-white dark:bg-neutral-800 border-gray-200 dark:border-neutral-700 rounded-lg sm:text-sm text-gray-800 dark:text-neutral-200 placeholder:text-gray-500 dark:placeholder:text-neutral-400 focus:border-gray-900 dark:focus:border-neutral-300 focus:ring-gray-900 dark:focus:ring-neutral-300 disabled:opacity-50 disabled:pointer-events-none"></textarea>
            </div> --}}
            <!-- End Grid -->
        </div>
        <div class="relative">
            <x-form.field-group label="{{ __('users.th.roles') }}" name="permissions">
                <!-- List Group -->
                <ul class="w-full flex flex-col">
                @foreach($roles as $role)
                    <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                        <div class="flex items-center justify-between w-full">
                            {{-- <span>{{ $role->name }}</span> --}}
                            <label for="permission_{{ $role->id }}" class="relative inline-block py-1.5 w-full cursor-pointer">{{ $role->name }}</label>
                            <span>
                                <div class="flex items-center">
                                    <label for="permission_{{ $role->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                        <input @checked($user->hasRole($role->id)) @disabled($action == 'show') type="checkbox" name="roles[]" value="{{ $role->id }}" id="permission_{{ $role->id }}" class="peer sr-only">
                                        <span class="absolute inset-0 bg-gray-200 dark:bg-neutral-600 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-gray-100 dark:peer-checked:bg-neutral-100 dark:peer-checked:bg-gray-800 dark:dark:peer-checked:bg-neutral-800 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-5 bg-plain rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-gray-800 dark:peer-checked:bg-white peer-checked:translate-x-full"></span>
                                        <!-- Left Icon (Off) -->
                                        <span class="absolute top-1/2 start-0.5 -translate-y-1/2 flex justify-center items-center size-5 text-gray-500 dark:text-neutral-400 peer-checked:text-gray-800 dark:peer-checked:text-white transition-colors duration-200">
                                            <x-feather-x class="shrink-0 size-3" />
                                        </span>
                                        <!-- Right Icon (On) -->
                                        <span class="absolute top-1/2 end-0.5 -translate-y-1/2 flex justify-center items-center size-5 text-gray-500 dark:text-neutral-400 peer-checked:text-white transition-colors duration-200">
                                            <x-feather-check class="shrink-0 size-3" />
                                        </span>
                                    </label>
                                </div>
                            </span>
                        </div>
                    </li>
                @endforeach
                <!-- End List Group -->
                </ul>
            </x-form.field-group>
        </div>
    </div>
</div>
