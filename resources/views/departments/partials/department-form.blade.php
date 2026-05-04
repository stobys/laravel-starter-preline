<div class="w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
    <div class="grid md:grid-cols-3 gap-4 lg:gap-6">
        <div class="md:col-span-2">
            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 py-2">
                <x-form.field-group for="name" name="name" label="{{ __('departments.th.name') }}">
                    <x-form.input required id="name" name="name" value="{{ old('name', $department->name ?? null) }}" />
                </x-form.field-group>

                <x-form.field-group for="manager_id" name="manager_id" label="{{ __('departments.th.manager') }}">
					<!-- Select -->
					<select name="manager_id" id="hs-participants-search" data-hs-select='{
						"hasSearch": true,
						"searchPlaceholder": "Search...",
						"searchClasses": "block w-full sm:text-sm bg-transparent border-layer-line rounded-lg text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus before:absolute before:inset-0 before:z-1 py-1.5 sm:py-2 px-3",
						"searchWrapperClasses": "bg-select p-2 -mx-1 sticky top-0",
						"placeholder": "Select manager ...",
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
						@foreach($users as $user)
							<option value="{{ $user->id }}" @selected($user->id == $department->manager_id) data-hs-select-option='{}'>
								{{ $user->full_name }}
							</option>
						@endforeach
					</select>
					<!-- End Select -->
                </x-form.field-group>
            </div>
            <!-- End Grid -->

            <!-- Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6 py-2">
                <x-form.field-group for="abbr" name="abbr" label="{{ __('departments.th.abbr') }}">
                    <x-form.input id="abbr" name="abbr" value="{{ old('abbr', $department->abbr ?? null) }}" />
                </x-form.field-group>

                <x-form.field-group for="teta_mpk_code" name="teta_mpk_code" label="{{ __('departments.th.mpk') }}">
                    <x-form.input id="teta_mpk_code" name="teta_mpk_code" value="{{ old('teta_mpk_code', $department->teta_mpk_code ?? null) }}" />
                </x-form.field-group>
            </div>
            <!-- End Grid -->
        </div>
    </div>
</div>
