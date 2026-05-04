@extends('layout.main')

@section('content')

    <!-- Content -->
	<x-form action="{{ route('departments.store') }}" class="flex-1 flex flex-col overflow-hidden">
		<!-- Header -->
		<div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
			<div>
				<h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
					{{ __('departments.labels.create-title') }}
				</h2>
				<p class="text-sm text-gray-600 dark:text-neutral-300">
					{{ __('departments.labels.create-title-helper') }}
				</p>
			</div>

			<!-- Button Group -->
			<div class="flex items-center gap-x-2">
				<a href="{{ route('departments.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
					<x-feather-x-circle class="shrink-0 size-4" />
					{{ __('app.actions.cancel') }}
				</a>

				<button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-green-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-green-700 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
					<x-feather-save class="shrink-0 size-4" />
					{{ __('app.actions.save') }}
				</button>
			</div>
			<!-- End Button Group -->
		</div>
		<!-- End Header -->

        <!-- Body -->
        <div class="flex-1 flex flex-col overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
            @includeIf('departments.partials.department-form', ['department' => new \App\Models\Department])

			<x-validation-errors />
			<x-auth-session-status class="mb-4" :status="session('status')" />
        </div>
        <!-- End Body -->
    </x-form>
    <!-- End Content -->

@endsection
