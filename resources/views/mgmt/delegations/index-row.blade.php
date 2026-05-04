<tr class="hover:bg-muted-hover">
    <x-table.td>
		<span @class([
				'size-3 inline-block rounded-full me-2',
				'bg-company-green'	=> $delegation->isValid(),
				'bg-red-500'	=> !$delegation->isValid() && $delegation->isPast(),
				'bg-blue-500'	=> !$delegation->isValid() && $delegation->isFuture(),
			])>
		</span>

		@if( $dir == 'incoming')
			{{ $delegation->principal->full_name }}
		@endif

		@if( $dir == 'outgoing')
			{{ $delegation->substitute->full_name }}
		@endif
    </x-table.td>
    <x-table.td>
        {{ $delegation->valid_from?->format('Y-m-d H:i') }}
	</x-table.td>
    <x-table.td>
        {{ $delegation->valid_to?->format('Y-m-d H:i') }}
	</x-table.td>
    <x-table.td class="text-center">
        <div class="inline-flex items-center text-sm gap-x-2">
			@if( $dir == 'incoming')
				@if( $delegation->isValid() )
				<a href="{{ route('users.impersonate', $delegation->principal_id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
					<x-feather-users class="size-4" />
				</a>
				@endif
			@endif

			@if( $dir == 'outgoing')
				<a href="{{ route('users.delegations.edit', $delegation->id) }}" class="inline-flex items-center text-sm text-gray-800 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
					<x-feather-edit class="size-4" />
				</a>
				<a href="{{ route('users.delegations.delete', $delegation->id) }}" class="inline-flex items-center text-sm text-red-600 dark:text-white decoration-2 hover:underline focus:outline-hidden focus:underline font-medium">
					<x-feather-trash-2 class="size-4" />
				</a>
			@endif
        </div>
    </x-table.td>
</tr>
