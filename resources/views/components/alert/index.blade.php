@props([
    'id'        => Str::random(10),
    'type'      => 'info',
    'icon'      => null,
    'title'     => null,
    'bordered'  => null,
    'accent'    => null,
    'dismiss'   => null,
    'close'   => null,
])

@php
    $dismissable = $dismiss || $close;
@endphp

<div {{ $attributes->merge(['id' => $id, 'role' => 'alert']) }}
    @class([
        'alert',
        'alert-info'        => $type === 'info',
        'alert-success'     => $type === 'success',
        'alert-warning'     => $type === 'warning',
        'alert-error'       => $type === 'error',
        'alert-dark'        => $type === 'dark',
        'bordered'          => $bordered,
        'border-t-accent'    => $accent === 't',
        'border-r-accent'    => $accent === 'r',
        'border-b-accent'    => $accent === 'b',
        'border-l-accent'    => $accent === 'l',
        'dismissable'        => $dismissable,
    ])
>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <svg class="shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <h3 class="font-medium">{{ $title }}</h3>
        </div>
        @if($dismissable)
        <div class="flex">
            <button type="button" class="dismiss ms-auto -mx-1.5 -my-1.5 rounded-lg  p-1.5 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#{{ $id }}" aria-label="{{ __('Close') }}">
                <span class="sr-only">{{ __('Dismiss') }}</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
        @endif
    </div>

    @if( !empty(trim($slot)) )
        <div class="mt-2 mb-4 text-sm">
            {{ $slot }}
        </div>
    @endif
</div>
