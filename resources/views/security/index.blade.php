@extends('layout.main')

@section('title', 'Security Audit')

@section('content')
	<div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-8">

	{{-- ── Header ──────────────────────────────────────────────────────────── --}}
	<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
		<div>
		<h1 class="text-2xl font-bold text-gray-900 dark:text-white">🛡️ Security Audit</h1>
		<p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
			@if($scannedAt)
			Ostatni skan:
			<span class="font-medium text-gray-700 dark:text-gray-300">
				{{ \Carbon\Carbon::parse($scannedAt)->format('d.m.Y H:i') }}
			</span>
			<span class="text-gray-400">({{ \Carbon\Carbon::parse($scannedAt)->diffForHumans() }})</span>
			@else
			Brak danych – uruchom audyt po raz pierwszy.
			@endif
		</p>
		</div>

		<button
		id="btn-run-audit"
		type="button"
		class="inline-flex items-center gap-x-2 py-2 px-4 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none transition-colors"
		>
		<svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
		</svg>
		<span id="btn-label">Uruchom audyt</span>
		</button>
	</div>

	{{-- ── Alert banners ───────────────────────────────────────────────────── --}}
	@if($stats['critical'] > 0)
		<div class="flex items-start gap-3 mb-6 p-4 rounded-xl bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
		<span class="text-xl mt-0.5">🔴</span>
		<div>
			<p class="text-sm font-semibold text-red-800 dark:text-red-200">
			{{ $stats['critical'] }} krytyczn{{ $stats['critical'] === 1 ? 'a luka wymaga' : 'e luki wymagają' }} natychmiastowej reakcji!
			</p>
			<p class="text-xs text-red-600 dark:text-red-300 mt-0.5">Zaktualizuj wskazane pakiety jak najszybciej.</p>
		</div>
		</div>
	@elseif($stats['high'] > 0)
		<div class="flex items-start gap-3 mb-6 p-4 rounded-xl bg-orange-50 border border-orange-200 dark:bg-orange-900/20 dark:border-orange-800">
		<span class="text-xl mt-0.5">🟠</span>
		<div>
			<p class="text-sm font-semibold text-orange-800 dark:text-orange-200">
			Wykryto {{ $stats['high'] }} luk{{ $stats['high'] === 1 ? 'ę' : 'i' }} o wysokim priorytecie.
			</p>
			<p class="text-xs text-orange-600 dark:text-orange-300 mt-0.5">Zalecana aktualizacja w najbliższym czasie.</p>
		</div>
		</div>
	@elseif($stats['total'] === 0 && $scannedAt)
		<div class="flex items-center gap-3 mb-6 p-4 rounded-xl bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800">
		<span class="text-xl">✅</span>
		<p class="text-sm font-semibold text-green-800 dark:text-green-200">
			Żadnych luk bezpieczeństwa. Twoje zależności są bezpieczne.
		</p>
		</div>
	@endif

	{{-- ── Stats cards ─────────────────────────────────────────────────────── --}}
	<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
		@foreach([
		['Łącznie',   $stats['total'],    'text-gray-900 dark:text-white',        'bg-white dark:bg-neutral-800 border-gray-200 dark:border-neutral-700'],
		['Krytyczne', $stats['critical'], 'text-red-600 dark:text-red-400',       'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800'],
		['Wysokie',   $stats['high'],     'text-orange-600 dark:text-orange-400', 'bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-800'],
		['Średnie',   $stats['medium'],   'text-yellow-600 dark:text-yellow-500', 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800'],
		['Niskie',    $stats['low'],      'text-blue-600 dark:text-blue-400',     'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800'],
		] as [$label, $value, $numClass, $bgClass])
		<div class="flex flex-col rounded-xl border {{ $bgClass }} p-4 shadow-sm">
			<div class="text-3xl font-extrabold {{ $numClass }}">{{ $value }}</div>
			<div class="mt-1 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $label }}</div>
		</div>
		@endforeach
	</div>

	{{-- ── Filters ─────────────────────────────────────────────────────────── --}}
	<form method="GET" action="{{ route('security.index') }}"
			class="flex flex-wrap items-end gap-3 mb-4">

		<div class="flex-1 min-w-[200px]">
		<label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Szukaj</label>
		<div class="relative">
			<svg class="absolute left-3 top-1/2 -translate-y-1/2 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
			<path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0Z"/>
			</svg>
			<input type="text" name="search" value="{{ $search }}"
				placeholder="Pakiet, CVE, tytuł…"
				class="py-2 pl-9 pr-3 w-full border border-gray-200 dark:border-neutral-600 rounded-lg text-sm bg-white dark:bg-neutral-800 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500"/>
		</div>
		</div>

		<div>
		<label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Priorytet</label>
		<select name="severity"
				class="py-2 px-3 border border-gray-200 dark:border-neutral-600 rounded-lg text-sm bg-white dark:bg-neutral-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
			<option value="">Wszystkie</option>
			<option value="critical" @selected($severity === 'critical')>🔴 Krytyczne</option>
			<option value="high"     @selected($severity === 'high')>🟠 Wysokie</option>
			<option value="medium"   @selected($severity === 'medium')>🟡 Średnie</option>
			<option value="low"      @selected($severity === 'low')>🔵 Niskie</option>
		</select>
		</div>

		<button type="submit"
				class="py-2 px-4 text-sm font-medium rounded-lg bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-gray-700 dark:hover:bg-gray-100 transition-colors">
		Filtruj
		</button>

		@if($search || $severity)
		<a href="{{ route('security.index') }}"
			class="py-2 px-3 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
			Wyczyść
		</a>
		@endif

	</form>

	{{-- ── Table ───────────────────────────────────────────────────────────── --}}
	<div class="bg-white dark:bg-neutral-800 rounded-xl border border-gray-200 dark:border-neutral-700 shadow-sm overflow-hidden">

		@if(! $scannedAt)
		<div class="py-20 text-center">
			<div class="text-5xl mb-4">🔍</div>
			<h3 class="text-base font-semibold text-gray-900 dark:text-white">Brak danych audytu</h3>
			<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
			Kliknij „Uruchom audyt" aby przeprowadzić pierwsze sprawdzenie.
			</p>
		</div>

		@elseif($vulnerabilities->isEmpty())
		<div class="py-20 text-center">
			<div class="text-5xl mb-4">✅</div>
			<h3 class="text-base font-semibold text-gray-900 dark:text-white">Brak wyników</h3>
			<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
			{{ ($search || $severity) ? 'Żadne luki nie pasują do filtrów.' : 'Nie wykryto żadnych luk bezpieczeństwa.' }}
			</p>
		</div>

		@else
		<div class="overflow-x-auto">
			<table class="min-w-full divide-y divide-gray-100 dark:divide-neutral-700">
			<thead class="bg-gray-50 dark:bg-neutral-700/50">
				<tr>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Priorytet</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pakiet</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Opis luki</th>
				<th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider hidden md:table-cell">CVE</th>
				<th class="px-4 py-3"></th>
				</tr>
			</thead>
			<tbody class="divide-y divide-gray-100 dark:divide-neutral-700">
				@foreach($vulnerabilities as $vuln)
				@php
					$badgeClass = match($vuln['severity']) {
					'critical' => 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300',
					'high'     => 'bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-300',
					'medium'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300',
					'low'      => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
					default    => 'bg-gray-100 text-gray-600 dark:bg-neutral-700 dark:text-gray-400',
					};
					$icon = match($vuln['severity']) {
					'critical' => '🔴', 'high' => '🟠', 'medium' => '🟡', 'low' => '🔵', default => '⚪',
					};
				@endphp
				<tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/30 transition-colors">

					<td class="px-4 py-3 whitespace-nowrap">
					<span class="inline-flex items-center gap-1 py-1 px-2.5 rounded-full text-xs font-bold {{ $badgeClass }}">
						{{ $icon }} {{ strtoupper($vuln['severity']) }}
					</span>
					</td>

					<td class="px-4 py-3">
					<div class="font-mono text-sm font-semibold text-gray-900 dark:text-white">{{ $vuln['package_name'] }}</div>
					<div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">v{{ $vuln['package_version'] }}</div>
					</td>

					<td class="px-4 py-3">
					<div class="text-sm text-gray-800 dark:text-gray-200">{{ $vuln['title'] }}</div>
					@if($vuln['affected'])
						<div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 font-mono">{{ $vuln['affected'] }}</div>
					@endif
					</td>

					<td class="px-4 py-3 whitespace-nowrap hidden md:table-cell">
					@if($vuln['cve_id'])
						<span class="font-mono text-xs bg-gray-100 dark:bg-neutral-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded">
						{{ $vuln['cve_id'] }}
						</span>
					@else
						<span class="text-gray-300 dark:text-gray-600 text-sm">–</span>
					@endif
					</td>

					<td class="px-4 py-3 text-right whitespace-nowrap">
					@if($vuln['link'])
						<a href="{{ $vuln['link'] }}" target="_blank" rel="noopener noreferrer"
						class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200">
						Advisory
						<svg class="size-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
						</svg>
						</a>
					@endif
					</td>

				</tr>
				@endforeach
			</tbody>
			</table>
		</div>

		<div class="px-4 py-3 border-t border-gray-100 dark:border-neutral-700 text-xs text-gray-400 dark:text-gray-500">
			Wyświetlono {{ $vulnerabilities->count() }} z {{ $stats['total'] }} luk/ę ·
			{{ $stats['packages'] }} {{ $stats['packages'] === 1 ? 'pakiet' : 'pakiety' }} z lukami
		</div>
		@endif

	</div>

	</div>

	{{-- Toast --}}
	<div id="toast"
		class="fixed bottom-5 right-5 hidden z-50 max-w-sm py-3 px-4 rounded-xl shadow-lg text-sm font-medium border transition-all">
	</div>

	@push('scripts')
		<script>
		(function () {
		const btn   = document.getElementById('btn-run-audit');
		const label = document.getElementById('btn-label');
		const toast = document.getElementById('toast');

		function showToast(msg, ok) {
			toast.textContent = msg;
			toast.className = `fixed bottom-5 right-5 z-50 max-w-sm py-3 px-4 rounded-xl shadow-lg text-sm font-medium border transition-all ${
			ok
				? 'bg-green-50 border-green-200 text-green-800 dark:bg-green-900/30 dark:border-green-700 dark:text-green-300'
				: 'bg-red-50 border-red-200 text-red-800 dark:bg-red-900/30 dark:border-red-700 dark:text-red-300'
			}`;
			setTimeout(() => toast.classList.add('hidden'), 4000);
		}

		btn.addEventListener('click', async () => {
			btn.disabled = true;
			label.textContent = 'Trwa skan…';

			try {
			const res  = await fetch('{{ route('security.run') }}', {
				method: 'POST',
				headers: {
				'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
				'Accept': 'application/json',
				},
			});
			const data = await res.json();
			showToast(data.success ? '✅ ' + data.message : '❌ ' + data.message, data.success);
			if (data.success) setTimeout(() => window.location.reload(), 1200);
			} catch {
			showToast('❌ Błąd połączenia.', false);
			} finally {
			btn.disabled = false;
			label.textContent = 'Uruchom audyt';
			}
		});
		})();
		</script>
	@endpush
@endsection
