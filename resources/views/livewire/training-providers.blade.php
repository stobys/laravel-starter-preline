    <section>
        <div class="mx-auto w-full shadow-sm rounded-lg mb-4 border border-gray-200 dark:border-gray-700">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex-row items-center justify-between p-4 sm:flex sm:space-y-0 sm:space-x-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h5 class="mr-3 font-semibold dark:text-gray-300">{{ __('training_providers.labels.training_providers_list') }}</h5>
                        <p class="text-adient-teal-3 dark:text-gray-400 text-sm">{{ __('training_providers.labels.training_providers_list_helper') }}</p>

                    </div>
                    <div class="flex items-center justify-between">
                        <a href="{{ route('training_providers.create') }}" type="button"
                            bg-new="adient-teal-1" bg-old="bg-primary-700"
                            class="flex items-center justify-center mr-2 px-4 py-2 text-sm font-medium rounded-lg focus:ring-4 focus:ring-primary-300 focus:outline-none dark:focus:ring-primary-800
                                border-gray-500
                                bg-adient-teal-1 hover:bg-adient-teal-2 text-adient-green-1
                                dark:bg-adient-green-1 dark:hover:bg-adient-green-2 dark:text-adient-teal-1
                                dark:bg-primary-600 dark:hover:bg-primary-700
                        ">
                            @svg('feather-plus', 'w-4 h-4 mr-2')
                            {{ __('Add new Training Provider') }}
                        </a>

                        <x-button.outline wire:click="exportToCSV()" class="me-2">
                            @svg('feather-download-cloud', 'w-4 h-4 mr-2')
                            {{ __('table.actions.export') }}
                        </x-button.outline>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    wire:model.live.debounce.300ms="search" placeholder="{{ __('app.placeholder.search') }}"
                                >
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <div class="flex w-40">
                                <label class="shrink-0 z-10 inline-flex items-center p-2 px-3 text-xs h-9 font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-700 dark:text-white dark:border-gray-600" type="button">
                                    @svg('feather-zap', 'w-4 h-4')
                                </label>
                                <select wire:model.live.debounce.300ms="is_active" class="w-40 p-2 px-3 text-xs h-9 text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg cursor-pointer w-36 sm:block hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white">
                                    @foreach ($statuses as $code => $label)
                                        <option value="{{ $code }}" @selected($is_active == $code)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400" x-data="tableRowToggler">
                        {{-- <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                            Our products
                            <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse a list of Flowbite products designed to help you work and play, stay organized, get answers, keep in touch, grow your business, and more.</p>
                        </caption> --}}
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 opacity-70">
                            <tr>
                                {{-- <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-rows-selector" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-rows-selector" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="p-4">
                                    <span x-on:click="toggleAllChildren">
                                        @svg('heroicon-s-arrow-turn-down-right', 'h-4 w-4 cursor-pointer')
                                    </span>
                                </th>
                                --}}
                                <th wire:click="sortBy('name')" scope="col" class="px-4 py-3 cursor-pointer">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        {{ __('training_providers.th.name') }}

                                        @if($sortField === 'name')
                                            @if($sortDir === 'asc')
                                                @svg('heroicon-s-chevron-up', 'h-3 w-3')
                                            @else
                                                @svg('heroicon-s-chevron-down', 'h-3 w-3')
                                            @endif
                                        @else
                                            @svg('heroicon-s-chevron-up-down', 'h-4 w-4')
                                        @endif
                                    </p>
                                </th>
                                <th wire:click="sortBy('address')" scope="col" class="px-4 py-3 cursor-pointer">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        {{ __('training_providers.th.address') }}

                                        @if($sortField === 'address')
                                            @if($sortDir === 'asc')
                                                @svg('heroicon-s-chevron-up', 'h-3 w-3')
                                            @else
                                                @svg('heroicon-s-chevron-down', 'h-3 w-3')
                                            @endif
                                        @else
                                            @svg('heroicon-s-chevron-up-down', 'h-4 w-4')
                                        @endif
                                    </p>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        {{ __('training_providers.th.trainings_count') }}
                                    </p>
                                </th>
                                <th scope="col" class="px-4 py-3">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        {{ __('training_providers.th.status') }}
                                    </p>
                                </th>
                                <th>
                                    {{ __('table.th.actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($models as $model)
                                <tr id="model-row-{{ $model->id }}" data-row-id="{{ $model->id }}" @class([
                                        'border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600',
                                        'text-gray-900 dark:text-gray-100',
                                    ])
                                >
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $model->name }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        {{ $model->address }}
                                    </td>
                                    <td class="px-4 py-3">{{ $model->trainings_count }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div @class(['h-2.5 w-2.5 rounded-full mr-2',
                                                'bg-green-600' => $model->is_active,
                                                'bg-red-600' => !$model->is_active
                                            ])></div>
                                            {{ $model->is_active ? __('training_providers.status.active') : __('training_providers.status.inactive') }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        {{-- @if($model->status->isRealized())
                                        @endif --}}
                                        <a href="#toggle" wire:click="activeToggle({{ $model->id }})"
                                            class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                            data-tooltip-target="tooltip-active-{{ $model->id }}"
                                        >
                                            @if($model->is_active)
                                                @svg('feather-zap-off', 'w-4 h-4 text-red-600')
                                            @else
                                                @svg('feather-zap', 'w-4 h-4 text-green-600')
                                            @endif
                                        </a>
                                        {{-- <x-tooltip id="tooltip-active-{{ $model->id }}" placement="bottom">
                                            {{ $model->is_active ? __('training_providers.actions.deactivate') : __('training_providers.actions.activate') }}
                                        </x-tooltip> --}}

                                        <a href="{{ route('training_providers.edit', $model->id) }}"
                                            class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                        >
                                            @svg('feather-edit', 'w-4 h-4')
                                            {{-- {{ __('table.actions.view') }} --}}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Brak Dostawców</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            @if($search)
                                                Nie znaleziono dostawców dla frazy "{{ $search }}"
                                            @else
                                                Zacznij od dodania nowego dostawcy.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4 border-t border-gray-200" aria-label="Table navigation">
                        <div class="flex">
                            <div class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                {{ __('app.labels.page-size') }}
                            </div>
                            <select id="pageSize" wire:model.live="pageSize" class="bg-gray-50 w-24 border border-gray-300 text-gray-900 text-sm rounded-e-lg border-s-gray-100 dark:border-s-gray-700 border-s-2 focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="1" @selected($pageSize == 1)>1</option>
                                <option value="5" @selected($pageSize == 5)>5</option>
                                <option value="10" @selected($pageSize == 10)>10</option>
                                <option value="15" @selected($pageSize == 15)>15</option>
                                <option value="20" @selected($pageSize == 20)>20</option>
                                <option value="50" @selected($pageSize == 50)>50</option>
                                <option value="100" @selected($pageSize == 100)>100</option>
                            </select>
                        </div>
                        {{-- <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                            Showing
                            <span class="font-semibold text-gray-900 dark:text-white">
                                1-10
                                /
                                Count : {{ $models -> count() }}
                                /
                                Current Page : {{ $models -> currentPage() }}
                            </span>
                            of
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $models->total() }}
                            </span>
                        </span> --}}

                        <!-- Paginacja -->
                        @if($models->hasPages())
                            <div class="bg-white px-4 py-3">
                                {{ $models->onEachSide(5)->links() }}
                            </div>
                        @endif

                    </nav>
                </div>
            </div>
        </div>
    </section>


@push('scripts')
    <script>

        Livewire.hook('component.rendered', ({ component, cleanup }) => {
            console.log('rendered!');
        });

        document.addEventListener('livewire:init', () => {
            console.log('livewire:init');
        });

        document.addEventListener('livewire:rendered', () => {
            console.log('livewire:rendered');
        });

    // $wire.on('loaded', () => {
    //     initFlowbite();
    // });

        // window.addEventListener('phx:page-loading-stop', () => {
        //     // Trigger Flowbite initialization
        //     window.document.dispatchEvent(new Event("DOMContentLoaded", {
        //         bubbles: true,
        //         cancelable: true
        //     }));
        // });

        // // Initialize active tab from URL
        // document.addEventListener('livewire:initialized', () => {
        //     // window.addEventListener('open-modal', event => {
        //     // });

        //     // const urlParams = new URLSearchParams(window.location.search);
        //     // const activeTab = urlParams.get('activeTab');
        //     // if (activeTab) {
        //     //     window.livewire.set('activeTab', activeTab);
        //     // }
        // });

        // document.addEventListener('DOMContentLoaded', () => {
        // });
    </script>
@endpush
