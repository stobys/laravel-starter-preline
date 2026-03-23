@extends('layout.main')

@section('content')

    <!-- Content -->
    <div class="h-[calc(100dvh-62px)] lg:h-full overflow-hidden flex flex-col bg-layer border border-layer-line shadow-xs rounded-lg">
        <!-- Header -->
        <div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Users
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-300">
                    List of users.
                </p>
            </div>

            <!-- Button Group -->
            <div class="flex items-center gap-x-2">
                <a  href="{{ route('users.create') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                    <x-feather-user-plus class="shrink-0 size-4" />
                    Add user
                </a>
            </div>
            <!-- End Button Group -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="flex-1 flex flex-col overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
            <!-- Table Section -->
            <div class="w-full px-6 py-6 mx-auto">
                <!-- Card -->
                <div class="flex flex-col">
                    <div class="overflow-x-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                        <div class="min-w-full inline-block align-middle">
                            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-xl shadow-2xs overflow-hidden">
                                <!-- Header -->
                                <x-form action="{{ route('users.filter') }}">
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-table-line">
                                        <!-- Input -->
                                        <div class="sm:col-span-1 md:grow">
                                            <div class="flex justify-start gap-x-2">
                                                <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
                                                <div class="relative">
                                                    <input type="text" name="filter[search]" value="{{ session('filters.users.search', null) }}" class="py-2 px-3 ps-11 block w-full bg-layer border-layer-line rounded-lg text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-fborder-primary-focus disabled:opacity-50 disabled:pointer-events-none" placeholder="Search">
                                                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                                        <x-feather-search class="size-4 text-muted-foreground" />
                                                    </div>
                                                </div>

                                                <div class="hs-dropdown [--placement:bottom-right] [--auto-close:inside] relative inline-block" data-hs-dropdown-auto-close="inside">
                                                    <button id="hs-as-table-table-filter-dropdown" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M7 12h10"></path><path d="M10 18h4"></path></svg>
                                                        Status
                                                    </button>
                                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 min-w-48 z-10 bg-dropdown border border-dropdown-line divide-y divide-dropdown-divider shadow-md rounded-lg mt-2 hidden" role="menu" aria-orientation="vertical" aria-labelledby="hs-as-table-table-filter-dropdown" tabindex="-1" data-placement="bottom-end" style="transform: translate3d(1007px, 121px, 0px);">
                                                        <div class="divide-y divide-dropdown-divider">
                                                            <label for="hs-as-filters-dropdown-published" class="flex items-center py-2.5 px-3">
                                                                <input type="checkbox" name="filter[status][]" value="1" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none" id="hs-as-filters-dropdown-published">
                                                                <span class="ms-3 text-sm text-foreground">Active</span>
                                                            </label>
                                                            <label for="hs-as-filters-dropdown-pending" class="flex items-center py-2.5 px-3">
                                                                <input type="checkbox" name="filter[status][]" value="0" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none" id="hs-as-filters-dropdown-pending">
                                                                <span class="ms-3 text-sm text-foreground">Inactive</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Input -->

                                        <div class="sm:col-span-2 md:grow">
                                            <div class="flex justify-end gap-x-2">
                                                <button type="submit" name="filter[submit]" value="filter" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                                                    <x-feather-filter class="shrink-0 size-4" />
                                                    Filter
                                                </button>

                                                <button type="submit" name="filter[submit]" value="clear" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" href="#">
                                                    <x-feather-filter class="shrink-0 size-4" />
                                                    Clear
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </x-form>
                                <!-- End Header -->

                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead class="bg-gray-50 dark:bg-neutral-800">
                                        <tr>
                                        <th scope="col" class="ps-6 py-3 text-start">
                                        <label for="hs-at-with-checkboxes-main" class="flex">
                                        <input type="checkbox" class="shrink-0 size-4 bg-transparent border-gray-300 dark:border-neutral-600 rounded-sm shadow-2xs text-gray-800 dark:text-white focus:ring-0 focus:ring-offset-0 checked:bg-gray-800 dark:checked:bg-white checked:border-gray-800 dark:checked:border-white disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-main">
                                        <span class="sr-only">Checkbox</span>
                                        </label>
                                        </th>

                                        <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">

                                            <a class="group inline-flex items-center gap-x-2 text-xs font-semibold uppercase text-foreground hover:text-muted-foreground-1 focus:outline-hidden focus:text-muted-foreground-1" href="#" target="_parent">
                                                Name
                                                <svg class="shrink-0 size-3.5 text-foreground" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"></path><path d="m7 9 5-5 5 5"></path></svg>
                                            </a>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Status
                                        </span>
                                        </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Password Age
                                        </span>
                                        </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                        <span class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                        Created
                                        </span>
                                        </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-end"></th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        @foreach($users as $user)
                                        @includeIf('mgmt.users.index-row', ['user' => $user])
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->

                                <!-- Footer -->
                                <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                                    <div>
                                    <p class="text-sm text-gray-600 dark:text-neutral-300">
                                    <span class="font-semibold text-gray-800 dark:text-neutral-200">{{ $users->count() }}</span> results
                                    </p>
                                    </div>

                                    <div>
                                    <div class="inline-flex gap-x-2">
                                    <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                    Prev
                                    </button>

                                    <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
                                    Next
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                    </button>
                                    </div>
                                    </div>
                                </div>
                                <!-- End Footer -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Table Section -->
        </div>
        <!-- End Body -->
    </div>
    <!-- End Content -->

@endsection
