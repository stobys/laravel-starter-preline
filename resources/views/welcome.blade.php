@extends('layout.main')

@section('content')

	<!-- Content -->
		<!-- Header -->
		<div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
			<div>
				<h1 class="flex items-center gap-2 font-medium text-lg text-foreground">
					Langing Page
					<x-heroicon-s-heart class="size-5 text-red-600" />
				</h1>
			</div>
		</div>
		<!-- End Header -->

		<!-- Body -->
		<div class="flex-1 flex flex-col overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
			<div class="mx-auto mt-20">
				<img src="https://picsum.photos/600/400" />
			</div>
		</div>
		<!-- End Body -->
	<!-- End Content -->

@endsection
