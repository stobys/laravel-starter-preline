<div class="sm:col-span-1 md:grow">
    <div class="flex justify-start gap-x-2">
        <label for="hs-as-table-product-review-search" class="sr-only">Search</label>
        <div class="relative">
            <input type="text" name="filters[search]" value="{{ session('filters.delegations.search', null) }}" class="py-2 px-3 ps-11 block w-full bg-layer border-layer-line rounded-lg text-sm text-foreground placeholder:text-muted-foreground-1 focus:border-primary-focus focus:ring-primary-fborder-primary-focus disabled:opacity-50 disabled:pointer-events-none" placeholder="Search">
            <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                <x-feather-search class="size-4 text-muted-foreground" />
            </div>
        </div>
    </div>
</div>
<div class="sm:col-span-2 md:grow">
    <div class="flex justify-end gap-x-2">
        <button type="submit" name="filters[submit]" value="filter" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
            <x-feather-filter class="shrink-0 size-4" />
            {{ __('app.actions.filter-run') }}
        </button>

        <button type="submit" name="filters[submit]" value="clear" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-focus disabled:opacity-50 disabled:pointer-events-none" href="#">
            <x-feather-filter class="shrink-0 size-4" />
            {{ __('app.actions.filter-clear') }}
        </button>
    </div>
</div>
