@props([
    'sortable'  => false,
    'model'     => null,
    'sortField' => null,
    'sortOrder' => 'asc',
])

@php
    $sessionSortField = session('sort.'. $model .'.field', null);
    $sessionSortOrder = session('sort.'. $model .'.order', null);

    if ($sessionSortField == $sortField) {
        $sortOrder = $sessionSortOrder === 'asc' ? 'desc' : 'asc';
    }
@endphp

<th scope="col" {{ $attributes }} @class([
        'ps-4 py-3 text-start uppercase text-xs font-semibold text-foreground',
        'hover:text-muted-foreground-1' => $sortable,
        $attributes->get('class'),
    ])
])>
    @if($sortable)
        <a href="{{ request()->sortUrl($sortField, $sortOrder) }}" class="group inline-flex items-center gap-x-2 focus:outline-hidden focus:text-muted-foreground-1" target="_parent">
            {{ $slot }}

            @if( $sessionSortField == $sortField )
                @if( $sessionSortOrder == 'asc')
                    <x-heroicon-s-arrow-up class="shrink-0 size-3" />
                @else
                    <x-heroicon-s-arrow-down class="shrink-0 size-3" />
                @endif
            @else
                <x-heroicon-s-arrows-up-down class="shrink-0 size-3" />
            @endif
        </a>
    @else
        {{ $slot }}
    @endif
</th>

{{--
    <x-heroicon-s-arrows-up-down class="shrink-0 size-3" />
    <x-heroicon-s-bars-arrow-down class="shrink-0 size-3" />
    <x-heroicon-s-bars-arrow-up class="shrink-0 size-3" />
--}}
