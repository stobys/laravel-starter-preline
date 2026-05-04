@props([
	'icon' => null,

	'title' 	=> 'Card Title',
	'helper'	=> null,
	'value' 	=> 'Value',

	// 'change' => '12.5%',
	// 'changeType' => 'up',
])

<!-- Card -->
<div {{ $attributes->merge(["class" => "flex flex-col bg-card border border-card-line shadow-2xs rounded-xl"]) }}>
	<div class="p-4 md:p-5 flex gap-x-4">
		@if($icon)
			<div class="shrink-0 flex justify-center items-center size-11 bg-surface rounded-lg">
				{{ $icon }}
			</div>
		@endif

		<div class="grow">
			<div class="flex items-center gap-x-2">
				<p class="text-xs uppercase text-muted-foreground-1">
					{{ $title }}
				</p>
				@if($helper)
				<div class="hs-tooltip">
					<div class="hs-tooltip-toggle">
						<svg class="shrink-0 size-4 text-muted-foreground-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
						<span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-tooltip border border-tooltip-line text-xs font-medium text-tooltip-foreground rounded-md shadow-2xs" role="tooltip">
							{{ $helper }}
						</span>
					</div>
				</div>
				@endif
			</div>
			<div class="mt-1 flex items-center gap-x-2">
				<h3 class="text-xl sm:text-2xl font-medium text-foreground">{{ $value }}</h3>
				{{--
				<span class="inline-flex items-center gap-x-1 py-0.5 px-2 rounded-full bg-green-100 text-green-900 dark:bg-green-800 dark:text-green-100">
					<svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
					<span class="inline-block text-xs font-medium">
						12.5%
					</span>
				</span>
				--}}
			</div>
		</div>
	</div>
</div>
<!-- End Card -->
