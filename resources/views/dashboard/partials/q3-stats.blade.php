<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.q3_budget') }}"
		helper="{{ __('dashboard.labels.q3_budget_helper') }}"
		value="{{ format_as_number($budget->q3_budget) }}">
		<x-slot name="icon">
			<x-feather-dollar-sign class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.planned_cost') }}"
		helper="{{ __('dashboard.labels.planned_cost_helper') }}"
		value="{{ format_as_number($budget->q3_planned_cost) }}">
		<x-slot name="icon">
			<x-feather-dollar-sign class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.avg_training_planned_cost') }}"
		value="{{ format_as_number($budget->q3_avg_training_planned_cost) }}">
		<x-slot name="icon">
			<x-feather-bar-chart-2 class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.avg_planned_cost_per_participant') }}"
		value="{{ format_as_number($budget->q3_avg_planned_cost_per_participant) }}">
		<x-slot name="icon">
			<x-feather-clock class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.trainings_count') }}"
		value="{{ format_as_number($budget->q3_trainings_count) }}">
		<x-slot name="icon">
			<x-feather-book-open class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.unique_participants_count') }}"
		value="{{ format_as_number($budget->q3_unique_participants_count) }}">
		<x-slot name="icon">
			<x-feather-users class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.all_participants_count') }}"
		value="{{ format_as_number($budget->q3_participants_count) }}">
		<x-slot name="icon">
			<x-feather-users class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>

	<x-stats.card1 class="hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		title="{{ __('dashboard.labels.budget_utilization') }}"
		value="{{ format_as_number($budget->q3_budget_planned_utilization_pct, 1) }}%">
		<x-slot name="icon">
			<x-feather-pie-chart class="shrink-0 size-5 text-muted-foreground-2" />
		</x-slot>
	</x-stats.card1>
</div>
<div class="grid grid-cols-8 gap-4 sm:gap-6">
	<x-card class="col-span-5 hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		header="{{ __('dashboard.labels.budget_utilization') }}"
	>
		<canvas id="Q3QuarterChart"></canvas>
	</x-card>
	<x-card class="col-span-3 hover:shadow-lg focus:outline-hidden focus:shadow-lg transition"
		header="{{ __('dashboard.labels.training_statuses_breakdown') }}"
	>
		<canvas id="Q3StateChart"></canvas>
	</x-card>
</div>
