@blaze

@props([
    'type' => 'text',
    'id' => Str::random(10),
    'name' => null,
    'value' => null,
    'required' => false,
    'readonly' => false,
])

<input type="{{ $type ?? 'text' }}" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
    {{ $required ? 'required' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    @class(["py-2.5 sm:py-3 px-4 block w-full bg-layer rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1",
        "border-red-500 focus:border-red-500 focus:ring-red-500" => $errors->has($name),
        "border-teal-500 focus:border-teal-500 focus:ring-teal-500" => !$errors->has($name)
    ])
    aria-describedby="{{ $name }}-error-helper">
    @if($type === 'password')
        <button type="button" data-hs-toggle-password='{
            "target": "#{{ $name }}"
        }' class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 dark:text-neutral-500 rounded-e-md focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300">
        <svg class="shrink-0 size-3.5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path class="hs-password-active:hidden" d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/>
            <path class="hs-password-active:hidden" d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/>
            <path class="hs-password-active:hidden" d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/>
            <line class="hs-password-active:hidden" x1="2" x2="22" y1="2" y2="22"/>
            <path class="hidden hs-password-active:block" d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/>
            <circle class="hidden hs-password-active:block" cx="12" cy="12" r="3"/>
        </svg>
        </button>
    @endif
