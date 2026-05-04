@blaze

@props([
    'type' => 'text',
    'id' => Str::random(10),
    'name' => null,
    'value' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
	'icon'	=> false,
])

@if($icon)
<div class="relative">
@endif

	<input {{ $attributes -> merge([
		'type' => $type ?? 'text',
		'id' => $id,
		'name' => $name,
		'value' => $value
	]) }}
	{{--
	type="{{ $type ?? 'text' }}" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}"
	--}}
    {{ $required ? 'required' : '' }}
    {{ $readonly ? 'readonly' : '' }}
    {{ $disabled ? 'disabled' : '' }}
    @class(["py-2.5 sm:py-3 px-4 block w-full bg-layer rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1",
        "border-red-500 focus:border-red-500 focus:ring-red-500" => $errors->has($name),
        "border-teal-500 focus:border-teal-500 focus:ring-teal-500" => !$errors->has($name),
		// "ps-11" => $icon, // -- for leading icon
		"pe-11" => $icon, // -- for trailing icon
    ])
    aria-describedby="{{ $name }}-error-helper">
    @if($type === 'password')
        <button type="button" data-hs-toggle-password='{
            "target": "#{{ $name }}"
        }' class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 dark:text-neutral-500 rounded-e-md focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300">
			<x-feather-eye class="shrink-0 size-3.5 hs-password-active:hidden" />
			<x-feather-eye-off class="shrink-0 size-3.5 hidden hs-password-active:block" />
        </button>
    @endif

@if($icon)
    {{-- <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4"><!--// leading icon //-->
      	{{ $icon }}
    </div> --}}
	<div class="absolute inset-y-0 end-0 flex items-center pointer-events-none z-20 pe-4"><!--// trailing icon //-->
		{{ $icon }}
	</div>
</div>
@endif
