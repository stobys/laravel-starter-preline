@blaze()
@props([
	'id'			=> Str::random(8),
	'name'			=> null,
	'checked'		=> false,
	'disabled'		=> false,
	'value'			=> null,
	'wire'			=> null,
	'wireTarget'	=> null,
])

<div class="flex items-center">
	<label for="{{ $id }}" {{ $attributes->merge(['class'=>'relative inline-block w-15 h-8 cursor-pointer']) }}>
		<input type="checkbox" id="{{ $id }}" name="{{ $name ?? $id }}" value="{{ $value }}" class="peer sr-only" @checked($checked) @disabled($disabled)
			@if($wire)
				wire:model.live="{{ $wire }}"
			@endif
		>
		{{--
			<span class="absolute inset-0 bg-surface-1 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-primary-100 dark:peer-checked:bg-primary-800 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
			<span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-7 bg-plain rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-primary-checked peer-checked:translate-x-full"></span>
		--}}
		<span class="absolute inset-0 bg-surface-1 rounded-full transition-colors duration-200 ease-in-out peer-checked:bg-primary-100 dark:peer-checked:bg-primary-800 peer-disabled:opacity-50 peer-disabled:pointer-events-none"></span>
		<span class="absolute top-1/2 start-0.5 -translate-y-1/2 size-7 bg-plain rounded-full shadow-xs transition-transform duration-200 ease-in-out peer-checked:bg-company-teal peer-checked:translate-x-full"></span>
		<!-- Left Icon (Off) -->
		<span class="absolute top-1/2 start-1.5 -translate-y-1/2 flex justify-center items-center size-5 text-muted-foreground-1 peer-checked:text-primary-checked transition-colors duration-200">
			<x-feather-x class="shrink-0 size-3.5" />
		</span>
		<!-- Right Icon (On) -->
		<span class="absolute top-1/2 end-1.5 -translate-y-1/2 flex justify-center items-center size-5 text-muted-foreground-1 peer-checked:text-company-green transition-colors duration-200">
			<x-feather-check class="shrink-0 size-3.5" />
		</span>
	</label>
</div>
