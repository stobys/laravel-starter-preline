<tr class="hover:bg-muted-hover">
    <x-table.td>
        <label for="hs-at-with-checkboxes-1" class="flex">
            <input type="checkbox" class="shrink-0 size-4 bg-transparent border-gray-300 dark:border-neutral-600 rounded-sm shadow-2xs text-gray-800 dark:text-white focus:ring-0 focus:ring-offset-0 checked:bg-gray-800 dark:checked:bg-white checked:border-gray-800 dark:checked:border-white disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-1">
            <span class="sr-only">Checkbox</span>
        </label>
    </x-table.td>
    <x-table.td>
        <div class="flex items-center gap-x-3">
            <img class="inline-block size-8 rounded-full" src="{{ route('users.avatar', $user->id) }}" alt="{{ $user->full_name }}">
            <div class="grow">
                <span @class(["block text-sm font-semibold",
                    "text-gray-800 dark:text-neutral-200" => !$user->trashed(),
                    "text-gray-400 dark:text-neutral-500" => $user->trashed()
                ])
                >
                    {{ $user->full_name }}
                    ({{ $user->username }})
                </span>
                <span class="block text-sm text-gray-500 dark:text-neutral-400">{{ $user->email }}</span>
            </div>
        </div>
    </x-table.td>
    <x-table.td>
        <div class="flex items-center gap-x-3">
            {{-- <img class="inline-block size-9.5 rounded-full" src="https://images.unsplash.com/photo-1531927557220-a9e23c1e4794?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=facearea&facepad=2&w=320&h=320&q=80" alt="Avatar"> --}}
            <div class="grow">
                <span class="block text-sm">
					{{ $user->department?->name }}
                </span>
				@if($user->department?->manager)
                <span class="inline-flex items-center text-xs gap-x-1.5 text-gray-500 dark:text-neutral-400">
					<x-feather-user class="size-3" />
						{{ $user->department?->manager?->full_name }}
				</span>
				@endif
            </div>
        </div>
	</x-table.td>
    <x-table.td>
        @forelse($user -> roles as $role)
            <span class="py-1 px-2 mx-1 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                {{ $role->name }}
            </span>
        @empty
            <span class="py-1 px-2 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                <x-feather-x class="size-2.5" />
                No Roles Assigned
            </span>
        @endif
    </x-table.td>
    <x-table.td>
        <div class="px-6 py-3">
			@if( $user -> trashed() )
				<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
					<x-feather-x class="size-2.5" />
					Inactive
				</span>
			@else
				<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
					<x-feather-check-circle class="size-2.5" />
					Active
				</span>
			@endif

			@if($user->is_built_in)
				<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
					<x-feather-cpu class="size-2.5" />
					Built In
				</span>
			@endif

			@if($user->is_domain_user)
				<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
					<x-feather-link class="size-2.5" />
					LDAP
				</span>
			@endif
			@if($user->teta_prac_id)
				<span class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
					<x-feather-link class="size-2.5" />
					TETA
				</span>
			@endif
        </div>
    </x-table.td>
    <x-table.td>
		@unless($user->is_domain_user)
        <span class="block text-sm text-gray-500 dark:text-neutral-400">
            {{ $user->password_age }} days
        </span>

        <div class="block flex w-full h-1.5 bg-gray-200 dark:bg-neutral-600 rounded-full overflow-hidden">
            <div @class([
                "flex flex-col justify-center overflow-hidden",
                "bg-red-500" => $user->hasExpiredPassword(),
                "bg-green-700" => !$user->hasExpiredPassword()
            ]) role="progressbar" style="width: {{ $user->password_age_percent }}%" aria-valuenow="{{ $user->password_age_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
		@else
			Domain User
		@endunless
    </x-table.td>
    <x-table.td class="text-center">
        <div class="inline-flex items-center text-sm gap-x-2">
            @unless($user->is_built_in)
                <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                    <x-feather-file class="size-4" />
                </a>
                <a href="{{ route('users.edit', $user->id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                    <x-feather-edit class="size-4" />
                </a>
                @if( $user -> trashed() )
                    <a href="{{ route('users.restore', $user->id) }}" class="inline-flex items-center text-sm text-orange-600 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                        <x-feather-trash class="size-4" />
                    </a>
                @else
                    <a href="{{ route('users.delete', $user->id) }}" class="inline-flex items-center text-sm text-red-600 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
                        <x-feather-trash-2 class="size-4" />
                    </a>
                @endif

				@canImpersonate()
					<a href="{{ route('users.impersonate', $user->id) }}" class="hs-tooltip [--placement:top] hs-tooltip-toggle">
						<x-feather-users class="size-4" />
						<x-tooltip>{{ __('users.actions.impersonate-take') }}</x-tooltip>
					</a>
				@endCanImpersonate
            @endunless
        </div>
    </x-table.td>
</tr>
