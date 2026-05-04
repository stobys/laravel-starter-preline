@extends('layout.flowbite.app')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }} !!
        </h2>
    </x-slot>

<style>
	.loading-spinner {
		position: absolute;
		top: 50%;
		left: 50%;
		margin: -24px;
		-webkit-animation: spin 3s linear infinite;
		-moz-animation: spin 3s linear infinite;
		animation: spin 3s linear infinite;
	}

	.loading-spinner path {
		color: var(--spinner-color); /* currentColor w SVG */
	}
</style>

<svg class="loading-spinner" width="48" height="48" viewBox="0 0 512 512">
    <path d="M69.3 125.868c-18.373 26.227-31.358 56.489-37.338 89.169h41.135c4.748-21.798 13.299-42.193 24.92-60.452l-17.056-17.056-11.661-11.661zm56.629-56.508c26.483-18.468 57.06-31.452 90.071-37.294v39.779c-22.306 4.906-43.136 13.796-61.703 25.883l-16.767-16.767-11.601-11.601zm316.552 316.552c18.617-26.697 31.662-57.556 37.434-90.875h-40.408c-4.895 22.404-13.806 43.323-25.94 61.962l16.865 16.865 12.048 12.048zm-56.508 56.629c-26.441 18.523-56.985 31.571-89.973 37.484v-41.769c21.896-4.737 42.38-13.309 60.711-24.976l17.154 17.154 12.108 12.108zm-317.405-57.283c-18.375-26.546-31.255-57.173-36.98-90.22h41.534c4.776 21.86 13.377 42.308 25.064 60.602l-17.225 17.225-12.393 12.393zm56.312 56.825c26.723 18.859 57.672 32.111 91.121 38.03v-41.995c-22.201-4.884-42.94-13.714-61.441-25.714l-17.03 17.03-12.65 12.65zm316.866-316.866c18.615 26.376 31.767 56.87 37.797 89.82h-40.008c-4.866-22.343-13.726-43.211-25.793-61.815l16.693-16.693 11.312-11.312zm-56.825-56.312c-26.198-18.134-56.37-30.916-88.919-36.751v39.551c22.002 4.759 42.578 13.39 60.976 25.143l16.888-16.888 11.055-11.055z" fill="currentColor"></path>
</svg>


    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 opacity-70">
            <tr>
                <th scope="col" class="px-4 py-3 cursor-pointer">
                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                        Department
                    </p>
                </th>
                <th wire:click="sortBy('type')" scope="col" class="px-4 py-3 cursor-pointer">
                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                        Manager
                    </p>
                </th>
                <th wire:click="sortBy('state')" scope="col" class="px-4 py-3 cursor-pointer">
                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                        Members
                    </p>
                </th>
                <th wire:click="sortBy('user')" scope="col" class="px-4 py-3 cursor-pointer">
                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                        Trainings Count
                    </p>
                </th>
                <th wire:click="sortBy('cost')" scope="col" class="px-4 py-3 cursor-pointer">
                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                        Sum Cost
                    </p>
                </th>
                <th wire:click="sortBy('starts_at')" scope="col" class="px-4 py-3 cursor-pointer">
                    Avg Cost
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($departments as $department)
                <tr id="model-row-{{ $department->id }}" data-row-id="{{ $department->id }}" @class([
                        'border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600',
                        'text-gray-900 dark:text-gray-100',
                    ])
                >
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $department->name }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $department->manager?->full_name }}
                    </td>
                    <td class="px-4 py-3 pe-5 whitespace-nowrap text-center">
                        {{ $department->members_count }}
                    </td>
                    <td class="px-4 py-3 pe-5 text-center">
                        {{ $department->trainings_count }}
                    </td>
                    <td class="px-4 py-3 text-right pr-4">
                        {{ Number::format($department->trainings_sum_cost ?? 0, locale: app()->getLocale()) }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ Number::format($department->trainings_avg_cost ?? 0, locale: app()->getLocale()) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Brak danych</h3>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
