@blaze

@props([
    'id'	=> Str::random(10),
    'name'	=> Str::random(10),

    'label' => null,
    'value' => null,

    'required' => false,
    'readonly' => false,

	'placeholder'	=> null,
	'helper'	=> null,
])

<div class="w-full space-y-3">
	<label for="{{ $id }}" class="block mb-3 text-sm font-medium text-foreground">{{ $label }}</label>
	<textarea id="{{ $id }}" name="{{ $name }}" class="py-2 px-3 sm:py-3 sm:px-4 block w-full bg-layer border-layer-line rounded-lg sm:text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-focus disabled:opacity-50 disabled:pointer-events-none [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb" rows="3" placeholder="{{ $placeholder }}" aria-describedby="{{ $id }}-helper-text">{{ $value }}</textarea>
	@if( $helper )
		<p class="mt-2 text-xs text-muted-foreground-1" id="{{ $id }}-helper-text">{{ $helper }}</p>
	@endif
</div>
