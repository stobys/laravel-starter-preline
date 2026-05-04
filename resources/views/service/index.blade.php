@extends('layout.main')

@section('content')

    <!-- Content -->
		<!-- Header -->
		<div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
			<div>
				<h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
					{{ __('service.labels.index-title') }}
				</h2>
				<p class="text-sm text-gray-600 dark:text-neutral-300">
					{{ __('service.labels.index-title-helper') }}
				</p>
			</div>
		</div>
		<!-- End Header -->

        <!-- Body -->
        <div class="flex-1 p-4 flex flex-col overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
			<livewire:service-task-panel />
        </div>
        <!-- End Body -->
    <!-- End Content -->

@endsection
