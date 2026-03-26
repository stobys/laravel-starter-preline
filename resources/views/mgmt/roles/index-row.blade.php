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
                    <span @class(["block text-sm font-semibold",
                        "text-gray-800 dark:text-neutral-200" => !$role->trashed(),
                        "text-gray-400 dark:text-neutral-500" => $role->trashed()
                    ])
                    >
                        {{ $role->name }}
                    </span>
                    <span class="block text-sm text-gray-500 dark:text-neutral-400">{{ $role->name }}</span>
                </div>
            </div>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        @if( $role -> trashed() )
            <div class="px-6 py-3">
                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                    <x-feather-x class="size-2.5" />
                    Inactive
                </span>
            </div>
        @else
            <div class="px-6 py-3">
                <span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                    <x-feather-check-circle class="size-2.5" />
                    Active
                </span>
            </div>
        @endif
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="block text-sm text-gray-500 dark:text-neutral-400">
                {{ $role->permissions_count }}
            </span>
       </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-3">
            <span class="text-sm text-gray-500 dark:text-neutral-400">{{ $role->created_at->format('Y-m-d') }}</span>
        </div>
    </td>
    <td class="size-px whitespace-nowrap">
        <div class="px-6 py-1.5 inline-flex items-center text-sm gap-x-2">
            @unless($role->is_built_in)
                <a href="{{ route('roles.show', $role->id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                    <x-feather-file class="size-4" />
                </a>
                <a href="{{ route('roles.edit', $role->id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                    <x-feather-edit class="size-4" />
                </a>
                @if( $role -> trashed() )
                    <a href="{{ route('roles.restore', $role->id) }}" class="inline-flex items-center text-sm text-orange-600 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                        <x-feather-trash class="size-4" />
                    </a>
                @else
                    <a href="{{ route('roles.delete', $role->id) }}" class="inline-flex items-center text-sm text-red-600 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                        <x-feather-trash-2 class="size-4" />
                    </a>
                @endif
            @endunless


        </div>
    </td>
</tr>
