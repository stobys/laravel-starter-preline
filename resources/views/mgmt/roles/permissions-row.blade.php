<tr>
    <td class="size-px whitespace-nowrap">
        <div class="ps-6 py-3">
            <label for="hs-at-with-checkboxes-1" class="flex">
                <input type="checkbox" class="shrink-0 size-4 bg-transparent border-gray-300 dark:border-neutral-600 rounded-sm shadow-2xs text-gray-800 dark:text-white focus:ring-0 focus:ring-offset-0 checked:bg-gray-800 dark:checked:bg-white checked:border-gray-800 dark:checked:border-white disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-1">
                <span class="sr-only">Checkbox</span>
            </label>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
            <div class="flex items-center gap-x-3">
                {{-- <img class="inline-block size-9.5 rounded-full" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80" alt="Avatar"> --}}
                <div class="grow">
                    <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $permission->name }}
                    </span>
                    <span class="block text-sm text-gray-500 dark:text-neutral-400">Tlumaczenie {{ $permission->name }}</span>
                </div>
            </div>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="block text-sm text-gray-500 dark:text-neutral-400">
                {{ $permission->resource->name }}
            </span>
       </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $permission->created_at->format('Y-m-d') }}</span>
        </div>
    </td>
</tr>
