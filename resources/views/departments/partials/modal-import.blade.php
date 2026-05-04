<x-form action="{{ route('departments.import') }}">
	<x-modal id="hs-departments-import-modal" title="{{ __('departments.labels.import-title') }}">
		<x-slot name="footer">
				<button type="button" data-hs-overlay="#hs-departments-import-modal" class="hs-dropup-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none">
					{{ __('app.actions.close') }}
				</button>
				<button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
					{{ __('app.actions.import') }}
				</button>
		</x-slot>
		<x-form.textarea name="departments" value="{{ old('departments') }}" label="Department Name ; Department Abbr" placeholder="Paste your CSV data here..." />

		@if($errors->any())
			<!-- Alert -->
			<div class="mt-3 bg-red-50 border border-red-200 text-sm text-red-800 rounded-lg p-4 dark:bg-red-500/20 dark:border-red-900 dark:text-red-400" role="alert" tabindex="-1" aria-labelledby="hs-with-list-label">
				<div class="flex">
					<div class="shrink-0">
						<svg class="shrink-0 size-4 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
					</div>
					<div class="ms-4">
						<h3 id="hs-with-list-label" class="text-sm font-semibold">
							{{ __('app.labels.validation-errors-title') }}
						</h3>
						<div class="mt-2 text-sm text-red-800 dark:text-red-300">
							<ul class="list-disc space-y-1 ps-5">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- End Alert -->
		@endif
	</x-modal>
</x-form>
