<div class="w-full px-6 py-4 mx-auto">
    <div class="grid gap-4 lg:gap-6">
        <!-- Grid -->
        <!-- Tab Nav -->
        <div class="border-b border-gray-200 dark:border-neutral-700">
            <nav id="hs-tabs" class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
                <button type="button" role="tab" id="tabs-with-underline-item-1"
                    data-hs-tab="#tabs-with-underline-1"
                    aria-selected="true" aria-controls="tabs-with-underline-1"
                    class="px-4 hs-tab-active:font-semibold hs-tab-active:text-gray-900 dark:hs-tab-active:text-neutral-300 hs-tab-active:after:bg-gray-900 dark:hs-tab-active:after:bg-neutral-300 relative py-4 px-1 inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-gray-500 dark:text-neutral-400 after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5 after:bg-transparent hover:text-gray-900 dark:hover:text-neutral-300 focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300 disabled:opacity-50 disabled:pointer-events-none active">
                        <x-feather-shield class="shrink-0 size-4" />
                        Role Info
                </button>
                <button type="button" role="tab" id="tabs-with-underline-item-2"
                    data-hs-tab="#tabs-with-underline-2"
                    aria-selected="false" aria-controls="tabs-with-underline-2"
                    class="px-4 hs-tab-active:font-semibold hs-tab-active:text-gray-900 dark:hs-tab-active:text-neutral-300 hs-tab-active:after:bg-gray-900 dark:hs-tab-active:after:bg-neutral-300 relative py-4 px-1 inline-flex items-center gap-x-2 text-sm whitespace-nowrap text-gray-500 dark:text-neutral-400 after:absolute after:-bottom-px after:inset-x-0 after:w-full after:h-0.5 after:bg-transparent hover:text-gray-900 dark:hover:text-neutral-300 focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                        <x-feather-user-check class="shrink-0 size-4" />
                        Permissions
                </button>
            </nav>
        </div>
        <!-- End Tab Nav -->

        <!-- Tab Content -->
        <div class="mt-3">
            <div id="tabs-with-underline-1" role="tabpanel" aria-labelledby="tabs-with-underline-item-1">
                <p class="text-gray-500 dark:text-neutral-400">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                        <x-form.field-group id="name" name="name" label="Name">
                            <x-form.input required id="name" name="name" value="{{ old('name', $role->name ?? null) }}" :readonly="$readonly ?? false" />
                        </x-form.field-group>
                    </div>
                </p>
            </div>
            <div id="tabs-with-underline-2" class="hidden" role="tabpanel" aria-labelledby="tabs-with-underline-item-2">
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
                    @foreach($resources as $resource)
                        <!-- List Group -->
                        <ul class="w-full flex flex-col">
                            <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm font-semibold bg-gray-100 dark:bg-neutral-700 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                <div class="flex items-center justify-between w-full">
                                    <span class="uppercase">{{ $resource->name }}</span>
                                </div>
                            </li>
                            @foreach($resource->permissions as $permission)
                            <li class="inline-flex items-center gap-x-2 py-3 px-4 text-sm bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white -mt-px first:rounded-t-lg first:mt-0 last:rounded-b-lg">
                                <div class="flex items-center justify-between w-full">
                                    <span>
                                        <label for="permission_{{ $permission->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                            {{ $permission->name }}
                                        </label>
                                    </span>
                                    <span>
                                        <div class="flex items-center">
                                            <label for="permission_{{ $permission->id }}" class="relative inline-block w-11 h-6 cursor-pointer">
                                                <input @disabled($readonly ?? false) @checked($role->hasPermissionTo($permission->id)) type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" class="peer sr-only">
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
                        </ul>
                        <!-- End List Group -->
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Tab Content -->
        <!-- End Grid -->
    </div>
</div>
