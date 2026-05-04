@props([
	'header'	=> null,
	'alert'		=> null,
	'footer' 	=> null,
])

<!-- Card -->
<div {{ $attributes->merge(["class" => "flex flex-col bg-card border border-card-line shadow-2xs rounded-xl"]) }}>
	{{-- <img class="w-full h-auto rounded-t-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image"> --}}
	@if($header)
		<div class="py-3 px-4 border-b border-card-line rounded-t-xl bg-surface">
			@if ($header instanceof \Illuminate\View\ComponentSlot)
				{{ $header }}
			@else
				<div class="text-muted-foreground-1">{{ $header }}</div>
			@endif
		</div>
	@endif

	@if($alert)
	<div class="py-3 px-4 bg-surface border-b border-card-divider text-sm text-foreground">
		<span class="font-semibold">Attention needed!</span> This is an alert box.
	</div>
	@endif

	<div class="p-4  ">
		{{ $slot }}
	</div>

	@if($footer)
		<div class="py-3 px-4 border-b border-card-line rounded-b-xl bg-surface">
			<p class="text-sm text-muted-foreground-1">{{ $footer }}</p>
		</div>
	@endif
	{{-- <img class="w-full h-auto rounded-b-xl" src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Card Image"> --}}
</div>
<!-- End Card -->
