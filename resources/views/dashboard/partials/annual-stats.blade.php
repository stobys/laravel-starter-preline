	<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.annual_budget') }}"
			helper="{{ __('dashboard.labels.annual_budget_helper') }}"
			value="{{ format_as_number($budget->annual_budget) }}">
			<x-slot name="icon">
				<x-feather-dollar-sign class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.planned_cost') }}"
			helper="{{ __('dashboard.labels.planned_cost_helper') }}"
			value="{{ format_as_number($budget->annual_planned_cost) }}">
			<x-slot name="icon">
				<x-feather-dollar-sign class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.avg_training_planned_cost') }}"
			value="{{ format_as_number($budget->annual_avg_training_planned_cost) }}">
			<x-slot name="icon">
				<x-feather-bar-chart-2 class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.avg_planned_cost_per_participant') }}"
			value="{{ format_as_number($budget->annual_avg_planned_cost_per_participant) }}">
			<x-slot name="icon">
				<x-feather-clock class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.trainings_count') }}"
			value="{{ format_as_number($budget->annual_trainings_count) }}">
			<x-slot name="icon">
				<x-feather-book-open class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.unique_participants_count') }}"
			value="{{ format_as_number($budget->annual_unique_participants_count) }}">
			<x-slot name="icon">
				<x-feather-users class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.all_participants_count') }}"
			value="{{ format_as_number($budget->annual_participants_count) }}">
			<x-slot name="icon">
				<x-feather-users class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>

		<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			title="{{ __('dashboard.labels.budget_utilization') }}"
			value="{{ format_as_number($budget->annual_budget_planned_utilization_pct, 1) }}%">
			<x-slot name="icon">
				<x-feather-pie-chart class="shrink-0 size-5 text-muted-foreground-2" />
			</x-slot>
		</x-stats.card1>
	</div>
	<div class="grid grid-cols-8 gap-4 sm:gap-6">
		<x-card class="col-span-5 hover:shadow-lg focus:outline-hidden focus:shadow-lg transition">
			<x-slot name="header">
				<div class="flex flex-wrap justify-between items-center gap-2">
					<div class="inline-flex gap-2 justify-center items-center text-muted-foreground-1">
						{{ __('dashboard.labels.budget_utilization') }}
					</div>
					<!-- Tab Nav -->
					<div class="flex">
					</div>
					<!-- End Tab Nav -->
				</div>
			</x-slot>
			<canvas id="AnnualQuarterChart"></canvas>
		</x-card>
		<x-card class="col-span-3 hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
			{{-- header="{{ __('dashboard.labels.training_statuses_breakdown') }}" --}}
		>
			<x-slot name="header">
				<div class="flex flex-wrap justify-between items-center gap-2">
					<div class="inline-flex gap-2 justify-center items-center text-muted-foreground-1">
						{{ __('dashboard.labels.training_statuses_breakdown') }}
					</div>
					<!-- Tab Nav -->
					<div class="flex">
						<!-- Tab Nav -->
						<nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
							<button type="button" class="active hs-tab-active:bg-surface-active hs-tab-active:text-surface-foreground hs-tab-active:hover:text-surface-foreground py-1 px-2.5 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-muted-foreground-1 rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
								id="tab-annual-state-count-item" aria-selected="true" data-hs-tab="#tab-annual-state-count" aria-controls="tab-annual-state-count" role="tab"
							>
								{{ __('dashboard.labels.by_count') }}
							</button>
							<button type="button" class="hs-tab-active:bg-surface-active hs-tab-active:text-surface-foreground hs-tab-active:hover:text-surface-foreground py-1 px-2.5 inline-flex items-center gap-x-2 bg-transparent text-sm font-medium text-center text-muted-foreground-1 rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
								id="tab-annual-state-percent-item" aria-selected="false" data-hs-tab="#tab-annual-state-percent" aria-controls="tab-annual-state-percent" role="tab"
							>
								{{ __('dashboard.labels.by_percent') }}
							</button>
						</nav>
						<!-- End Tab Nav -->
					</div>
					<!-- End Tab Nav -->
				</div>
			</x-slot>

			<!-- Tab Content -->
			<div class="">
				<div id="tab-annual-state-count" class="hidden" role="tabpanel" aria-labelledby="tab-annual-state-count-item">
					<canvas id="annualStateCountChart"></canvas>
				</div>
				<div id="tab-annual-state-percent" class="hiddens" role="tabpanel" aria-labelledby="tab-annual-state-percent-item">
					<canvas id="annualStatePercentChart"></canvas>
				</div>
			</div>
			<!-- End Tab Content -->

		</x-card>
	</div>
