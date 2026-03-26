<div class="sm:col-span-1 md:grow">
    <div class="flex justify-start gap-x-2">
        <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
        <div class="relative">
            <input type="text" name="filters[search]" value="{{ session('filters.roles.search', null) }}" class="py-2 px-3 ps-11 block w-full bg-layer border-layer-line rounded-lg text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-fborder-primary-focus disabled:opacity-50 disabled:pointer-events-none" placeholder="Search">
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
                        <input type="checkbox" name="filters[status][]" value="1" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none" id="hs-as-filters-dropdown-published"
                            @checked(is_array(session('filters.roles.status')) && in_array(1, session('filters.roles.status')))
                        >
                        <span class="ms-3 text-sm text-foreground">Active</span>
                    </label>
                    <label for="hs-as-filters-dropdown-pending" class="flex items-center py-2.5 px-3">
                        <input type="checkbox" name="filters[status][]" value="0" class="shrink-0 size-4 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none" id="hs-as-filters-dropdown-pending"
                            @checked(is_array(session('filters.roles.status')) && in_array(0, session('filters.roles.status')))
                        >
                        <span class="ms-3 text-sm text-foreground">Inactive</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sm:col-span-2 md:grow">
    <div class="flex justify-end gap-x-2">
        <button type="submit" name="filters[submit]" value="filter" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
            <x-feather-filter class="shrink-0 size-4" />
            Filter
        </button>

        <button type="submit" name="filters[submit]" value="clear" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" href="#">
            <x-feather-filter class="shrink-0 size-4" />
            Clear
        </button>
    </div>
</div>
