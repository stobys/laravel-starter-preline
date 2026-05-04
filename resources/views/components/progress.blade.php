@props([
	'percent' => 0,
])

<div {{ $attributes->merge([
	'class' => 'flex w-full h-1.5 bg-surface-1 rounded-full overflow-hidden',
	'role' => 'progressbar',
	'aria-valuenow' => $percent,
	'aria-valuemin' => '0',
	'aria-valuemax' => '100'
]) }}>
	<div class="flex flex-col justify-center rounded-full overflow-hidden bg-primary text-xs text-primary-foreground text-center whitespace-nowrap transition duration-500" style="width: {{ $percent }}%"></div>
</div>
