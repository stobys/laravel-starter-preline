@extends('layout.main')

@section('content')
		<!-- Header -->
		<div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
            <div class="inline-flex gap-2 justify-center items-center">
				<h1 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
					{{ __('dashboard.labels.index-title') }}
				</h1>
				<!-- Account Dropdown -->
				<div class="hs-dropdown [--strategy:absolute] [--auto-close:inside] relative w-full inline-flex">
					<button id="hs-sidebar-header-example-with-dropdown" type="button" class="w-full inline-flex shrink-0 items-center gap-x-2 p-2 text-start text-sm text-gray-800 dark:text-neutral-200 rounded-md hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
						<x-feather-calendar class="shrink-0 size-4" />
						#{{ $year }}
						<svg class="shrink-0 size-3.5 ms-auto" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
					</button>

					<div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-56 transition-[opacity,margin] duration opacity-0 hidden z-20 bg-white dark:bg-neutral-900 border border-transparent rounded-lg shadow-lg" role="menu" aria-orientation="vertical" aria-labelledby="hs-sidebar-header-example-with-dropdown">
						<div class="p-1">
							<!-- Item -->
							@foreach($budgets as $item)
							<a href="{{ route('dashboard.dashboard', $item->fiscal_year) }}" class="py-2 px-2.5 group flex justify-start items-center gap-x-3 rounded-lg cursor-pointer text-[13px] text-dropdown-item-foreground hover:bg-dropdown-item-hover focus:outline-hidden focus:bg-dropdown-item-focus">
								<span class="grow">
									<span class="block text-sm font-medium text-foreground">
										{{ $item->fiscal_year }}
									</span>
								</span>
								@if($item->fiscal_year == $year)
									<x-feather-check class="shrink-0 size-4" />
								@endif
							</a>
							@endforeach
						</div>
					</div>
				</div>
				<!-- End Account Dropdown -->
            </div>
			<!-- Tab Nav -->
			<div class="flex">
				<div class="flex bg-surface hover:bg-surface-hover rounded-lg transition p-1">
					<nav class="flex gap-x-1" aria-label="Tabs" role="tablist" aria-orientation="horizontal">
						<button type="button" role="tab" id="segment-annual-stats-item" aria-selected="true" data-hs-tab="#segment-annual-stats" aria-controls="segment-annual-stats"
							class="active hs-tab-active:bg-layer hs-tab-active:text-layer-foreground py-2 px-3 inline-flex items-center gap-x-2 bg-transparent text-sm text-muted-foreground-1 focus:outline-hidden font-medium rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ __('budgets.labels.tab_annual') }}
						</button>
						<button type="button" role="tab" id="segment-q1-stats-item" aria-selected="false" data-hs-tab="#segment-q1-stats" aria-controls="segment-q1-stats"
							class="hs-tab-active:bg-layer hs-tab-active:text-layer-foreground py-2 px-3 inline-flex items-center gap-x-2 bg-transparent text-sm text-muted-foreground-1 focus:outline-hidden font-medium rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ __('budgets.labels.tab_q1') }}
						</button>
						<button type="button" role="tab" id="segment-q2-stats-item" aria-selected="false" data-hs-tab="#segment-q2-stats" aria-controls="segment-q2-stats"
							class="hs-tab-active:bg-layer hs-tab-active:text-layer-foreground py-2 px-3 inline-flex items-center gap-x-2 bg-transparent text-sm text-muted-foreground-1 focus:outline-hidden font-medium rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ __('budgets.labels.tab_q2') }}
						</button>
						<button type="button" role="tab" id="segment-q3-stats-item" aria-selected="false" data-hs-tab="#segment-q3-stats" aria-controls="segment-q3-stats"
							class="hs-tab-active:bg-layer hs-tab-active:text-layer-foreground py-2 px-3 inline-flex items-center gap-x-2 bg-transparent text-sm text-muted-foreground-1 focus:outline-hidden font-medium rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ __('budgets.labels.tab_q3') }}
						</button>
						<button type="button" role="tab" id="segment-q4-stats-item" aria-selected="false" data-hs-tab="#segment-q4-stats" aria-controls="segment-q4-stats"
							class="hs-tab-active:bg-layer hs-tab-active:text-layer-foreground py-2 px-3 inline-flex items-center gap-x-2 bg-transparent text-sm text-muted-foreground-1 focus:outline-hidden font-medium rounded-lg hover:text-primary-hover focus:outline-hidden focus:text-primary-focus disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ __('budgets.labels.tab_q4') }}
						</button>
					</nav>
				</div>
			</div>
			<!-- End Tab Nav -->
		</div>
		<!-- End Header -->

		<!-- Body -->
		<div class="flex-1 flex flex-col overflow-hidden overflow-y-scroll
			[&::-webkit-scrollbar]:w-1.5
			[&::-webkit-scrollbar-track]:rounded-none
			[&::-webkit-scrollbar-track]:bg-gray-100
			[&::-webkit-scrollbar-thumb]:rounded-none
			[&::-webkit-scrollbar-thumb]:bg-gray-300
			dark:[&::-webkit-scrollbar-track]:bg-neutral-700
			dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500
			">

			<div id="chart-data"
				data-state-colors='@json($stateColors)'
				data-annual-by-state-count='@json($annualByStateCount)'
				data-annual-by-state-percent='@json($annualByStatePercent)'

				data-annual-quarterly-target='@json($annualByQuarterTarget)'
				data-annual-quarterly-labels='@json($annualByQuarterLabels)'
				data-annual-quarterly-planned-values='@json($annualByQuarterPlannedValues)'
				data-annual-quarterly-actual-values='@json($annualByQuarterActualValues)'
			></div>
			<div id="all-charts-data"
				data-all-in-one='@json($budget)'
			></div>


			<div class="flex-1 flex flex-col lg:flex-row">
				<div class="flex-1 min-w-0 flex flex-col border-e border-layer-line">
					{{-- <div> --}}
						<!-- Tab Content -->
						<div id="segment-annual-stats" role="tabpanel" aria-labelledby="segment-annual-stats-item" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
							@includeIf('dashboard.partials.annual-stats')
						</div>
						<div id="segment-q1-stats" role="tabpanel" aria-labelledby="segment-q1-stats-item" class="hidden p-4 sm:p-6 space-y-4 sm:space-y-6" >
							@includeIf('dashboard.partials.q1-stats')
						</div>
						<div id="segment-q2-stats" role="tabpanel" aria-labelledby="segment-q2-stats-item" class="hidden p-4 sm:p-6 space-y-4 sm:space-y-6">
							@includeIf('dashboard.partials.q2-stats')
						</div>
						<div id="segment-q3-stats" role="tabpanel" aria-labelledby="segment-q3-stats-item" class="hidden p-4 sm:p-6 space-y-4 sm:space-y-6">
							@includeIf('dashboard.partials.q3-stats')
						</div>
						<div id="segment-q4-stats" role="tabpanel" aria-labelledby="segment-q4-stats-item" class="hidden p-4 sm:p-6 space-y-4 sm:space-y-6">
							@includeIf('dashboard.partials.q4-stats')
						</div>
						<!-- End Tab Content -->
					{{-- </div> --}}
				</div>
			</div>
		</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	const chartsData = document.getElementById('chart-data').dataset;

	const stateColors    = JSON.parse(chartsData.stateColors ?? '{}');
	const annualByStateCount    = JSON.parse(chartsData.annualByStateCount ?? '{}');
	const annualByStatePercent  = JSON.parse(chartsData.annualByStatePercent ?? '{}');

	const annualQuarterlyLabels = JSON.parse(chartsData.annualQuarterlyLabels);
	const annualQuarterlyTarget = JSON.parse(chartsData.annualQuarterlyTarget);
	const annualQuarterlyPlannedValues = JSON.parse(chartsData.annualQuarterlyPlannedValues);
	const annualQuarterlyActualValues = JSON.parse(chartsData.annualQuarterlyActualValues);

	const quarterData = {
		labels: annualQuarterlyLabels,
		planned: annualQuarterlyPlannedValues,
		actual: annualQuarterlyActualValues,
		budget_share: annualQuarterlyTarget,
	};

	const annualStateCountData = {
		labels: Object.keys(annualByStateCount),
		values: Object.values(annualByStateCount),
	};

	const annualStatePercentData = {
		labels: Object.keys(annualByStatePercent),
		values: Object.values(annualByStatePercent),
	};

	// ── Helpers ────────────────────────────────────────────────────────────
	const fmt = n => new Intl.NumberFormat('pl-PL').format(Math.round(n));
	const pct = n => Math.round(n * 10) / 10;
	const isDark = () => document.documentElement.getAttribute('data-theme') === 'dark';
	const textColor = () => isDark() ? '#cdccca' : '#28251d';
	const mutedColor = () => isDark() ? '#797876' : '#7a7974';
	const borderColor = () => isDark() ? '#393836' : '#d4d1ca';
	const surfaceColor = () => isDark() ? '#201f1d' : '#fbfbf9';

	// ── Charts ─────────────────────────────────────────────────────────────
	let annualStateCountChartInst, annualStatePercentChartInst, quarterChartInst;

	function chartDefaults() {
		return {
			color: textColor(),
			plugins: {
				legend: { labels: { color: mutedColor(), font: { family: "'Inter'" }, boxWidth: 12, padding: 16 } },
				tooltip: { backgroundColor: surfaceColor(), titleColor: textColor(), bodyColor: mutedColor(), borderColor: borderColor(), borderWidth: 1, padding: 10 }
			},
			scales: {
				x: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 } }, grid: { color: borderColor() } },
				y: { ticks: { color: mutedColor(), font: { family: "'Inter'", size: 11 }, callback: v => fmt(v) + ' zł' }, grid: { color: borderColor() } }
			}
		};
	}

	function buildAllCharts() {
		// const allData = JSON.parse(document.getElementById('all-charts-data').getAttribute('data-all-in-one'));
		// buildCharts(allData.annualByState);
		// buildTrendChart(allData.trendData);
	}

	function buildAnnualCharts() {
		const cd = chartDefaults();

		// -- Quarter BarChart
		if (quarterChartInst) quarterChartInst.destroy();
		quarterChartInst = new Chart(document.getElementById('AnnualQuarterChart'), {
			type: 'bar',
			data: {
				labels: quarterData.labels,
				datasets: [
					{ label: 'Limit kwartalny', data: quarterData.budget_share, backgroundColor: isDark() ? 'rgba(79,152,163,.15)' : 'rgba(1,105,111,.1)', borderColor: isDark() ? 'rgba(79,152,163,.4)' : 'rgba(1,105,111,.3)', borderWidth: 1, borderRadius: 4, type: 'bar' },
					{ label: 'Koszt planowany', data: quarterData.planned, backgroundColor: '#3b82f6', borderRadius: 4, type: 'bar' },
					{ label: 'Koszt faktyczny', data: quarterData.actual, backgroundColor: '#16a34a', borderRadius: 4, type: 'bar' },
				]
			},
			options: {
				...cd,
				responsive: true,
				maintainAspectRatio: false,
				plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'bottom' } }
			}
		});

		// -- State Count Doughnut
		if (annualStateCountChartInst) annualStateCountChartInst.destroy();
		annualStateCountChartInst = new Chart(document.getElementById('annualStateCountChart'), {
			type: 'doughnut',
			data: {
				labels: annualStateCountData.labels,
				datasets: [{
					data: annualStateCountData.values,
					backgroundColor: stateColors,
					borderColor: isDark() ? '#1c1b19' : '#f9f8f5',
					borderWidth: 1,
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '65%',
				plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'right' } }
			}
		});

		// -- State Percent Doughnut
		if (annualStatePercentChartInst) annualStatePercentChartInst.destroy();
		annualStatePercentChartInst = new Chart(document.getElementById('annualStatePercentChart'), {
			type: 'doughnut',
			data: {
				labels: annualStatePercentData.labels,
				datasets: [{
					data: annualStatePercentData.values,
					backgroundColor: stateColors,
					borderColor: isDark() ? '#1c1b19' : '#f9f8f5',
					borderWidth: 1,
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '65%',
				plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'right' } }
			}
		});

	}

	function buildCharts(byState) {
		const cd = chartDefaults();

		// Quarter BarChart
		if (quarterChartInst) quarterChartInst.destroy();
		quarterChartInst = new Chart(document.getElementById('AnnualQuarterChart'), {
			type: 'bar',
			data: {
				labels: quarterData.labels,
				datasets: [
					{ label: 'Limit kwartalny', data: quarterData.budget_share, backgroundColor: isDark() ? 'rgba(79,152,163,.15)' : 'rgba(1,105,111,.1)', borderColor: isDark() ? 'rgba(79,152,163,.4)' : 'rgba(1,105,111,.3)', borderWidth: 1, borderRadius: 4, type: 'bar' },
					{ label: 'Koszt planowany', data: quarterData.planned, backgroundColor: isDark() ? 'rgba(79,152,163,.7)' : 'rgba(1,105,111,.75)', borderRadius: 4, type: 'bar' },
				]
			},
			options: {
				...cd,
				responsive: true,
				maintainAspectRatio: false,
				plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'top' } }
			}
		});

		// State doughnut
		if (stateChartInst) stateChartInst.destroy();
		stateChartInst = new Chart(document.getElementById('annualStateChart'), {
			type: 'doughnut',
			data: {
				labels: annualStateData.labels,
				datasets: [{
					data: annualStateData.values,
					backgroundColor: ['rgba(232,175,52,.75)','rgba(85,145,199,.75)','rgba(109,170,69,.75)','rgba(209,99,167,.75)'],
					borderColor: isDark() ? '#1c1b19' : '#f9f8f5',
					borderWidth: 2,
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				cutout: '65%',
				plugins: { ...cd.plugins, legend: { ...cd.plugins.legend, position: 'bottom' } }
			}
		});

	}

	// ── Init & Events ──────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
		buildAnnualCharts();
	});

	document.addEventListener('change.hs.tab', (event) => {
		// console.log(event.target.dataset.hsTab);
		switch(event.target.dataset.hsTab)
		{
			case '#segment-annual-stats':
				buildAnnualCharts();
				break;

			case '#segment-q1-stats':
				// buildQ1Charts();
				break;

			case '#segment-q2-stats':
				// buildQ2Charts();
				break;

			case '#segment-q3-stats':
				// buildQ3Charts();
				break;

			case '#segment-q4-stats':
				// buildQ4Charts();
				break;

			case '#tab-annual-state-count':
				annualStateCountChartInst.resize();
				break;

			case '#tab-annual-state-count':
				annualStatePercentChartInst.resize();
				break;

		}
	});

</script>
@endpush
