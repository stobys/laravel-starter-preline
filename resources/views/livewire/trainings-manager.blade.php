<section>
    <div class="mx-auto w-full shadow-sm rounded-lg mb-4 border border-gray-200 dark:border-gray-700">
        <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg">
            <div class="flex-row items-center justify-between p-4 sm:flex sm:space-y-0 sm:space-x-4 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h5 class="mr-3 font-semibold dark:text-gray-300">{{ __('trainings.labels.trainings_list') }}</h5>
                    <p class="text-adient-teal-3 dark:text-gray-400 text-sm">{{ __('trainings.labels.trainings_list_helper') }}</p>
                </div>
                <div class="flex items-center justify-between">
                    @can('create', App\Models\Training::class)
                    <a href="{{ route('trainings.create') }}" type="button"
                        bg-new="adient-teal-1" bg-old="bg-primary-700"
                        class="flex items-center justify-center mr-2 px-4 py-2 text-sm font-medium rounded-lg focus:ring-4 focus:ring-primary-300 focus:outline-none dark:focus:ring-primary-800
                            border-gray-500
                            bg-adient-teal-1 hover:bg-adient-teal-2 text-adient-green-1
                            dark:bg-adient-green-1 dark:hover:bg-adient-green-2 dark:text-adient-teal-1
                            dark:bg-primary-600 dark:hover:bg-primary-700
                    ">
                        @svg('feather-plus', 'w-4 h-4 mr-2')
                        {{ __('Add new Training') }}
                    </a>
                    @endcan

                    @can('import', Training::class)
                    <x-button.outline data-drawer="import-trainings-drawer" class="me-2"
                        @click="$dispatch('drawer-toggle', { name: $el.dataset.drawer })"
                    >
                        @svg('feather-upload-cloud', 'w-4 h-4 mr-2')
                        {{ __('table.actions.import') }}
                    </x-button.outline>
                    @endcan

                    <x-button.outline data-drawer="export-trainings-drawer" class="me-2"
                        @click="$dispatch('drawer-toggle', { name: $el.dataset.drawer })"
                    >
                        @svg('feather-download-cloud', 'w-4 h-4 mr-2')
                        {{ __('table.actions.export') }}
                    </x-button.outline>

                    <x-button.outline data-drawer="columns-drawer" class="me-2"
                        @click="$dispatch('drawer-toggle', { name: $el.dataset.drawer })"
                    >
                        @svg('feather-settings', 'w-4 h-4 mr-2')
                        {{ __('common.actions.columns') }}
                    </x-button.outline>

                </div>
            </div>

            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="w-full md:w-2/5">
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
                                @svg('feather-user', 'w-4 h-4')
                            </label>
                            <select wire:model.live.debounce.300ms="member" class="w-40 p-2 px-3 text-xs h-9 text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg cursor-pointer w-36 sm:block hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white">
                                <option value="any">{{ __('users.any') }}</option>
                                @foreach ($teamMembers as $id => $username)
                                    <option value="{{ $id }}">{{ $username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex w-40">
                            <label class="shrink-0 z-10 inline-flex items-center p-2 px-3 text-xs h-9 font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-700 dark:text-white dark:border-gray-600" type="button">
                                @svg('feather-tag', 'w-4 h-4')
                            </label>
                            <select wire:model.live.debounce.300ms="member" class="w-40 p-2 px-3 text-xs h-9 text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg cursor-pointer w-36 sm:block hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white">
                                <option value="0">{{ __('trainings.type.any') }}</option>
                                @foreach ($types as $code => $label)
                                    <option value="{{ $code }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex w-52">
                            <label class="shrink-0 z-10 inline-flex items-center p-2 px-3 text-xs h-9 font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-700 dark:text-white dark:border-gray-600" type="button">
                                @svg('feather-git-commit', 'w-4 h-4')
                            </label>
                            <select wire:model.live.debounce.300ms="status" class="hidden w-48 p-2 px-3 text-xs h-9 text-gray-900 bg-gray-100 border border-gray-300 rounded-e-lg cursor-pointer w-36 sm:block hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white">
                                <option value="0">{{ __('trainings.status.any') }}</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->value }}" class="py-1" style="background-color: {{ $status->color() }}">{{ $status->label() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    {{-- <caption class="p-5 text-lg font-semibold text-left rtl:text-right text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                        Our products
                        <p class="mt-1 text-sm font-normal text-gray-500 dark:text-gray-400">Browse a list of Flowbite products designed to help you work and play, stay organized, get answers, keep in touch, grow your business, and more.</p>
                    </caption> --}}
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            @if($visibleColumns['id'] ?? $defaultColumns['id'])
                            <th scope="col" class="px-4 py-3">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    {{ __('common.th.id') }}
                                </p>
                            </th>
                            @endif

                            @if($visibleColumns['title'] ?? $defaultColumns['title'])
                            <th wire:click="sortBy('title')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    {{ __('trainings.th.title') }}

                                    @if($sortField === 'title')
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
                            @endif

                            @if($visibleColumns['provider'] ?? $defaultColumns['provider'])
                            <th wire:click="sortBy('provider')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    {{ __('trainings.th.provider') }}

                                    @if($sortField === 'provider')
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
                            @endif

                            @if($visibleColumns['user'] ?? $defaultColumns['user'])
                            <th wire:click="sortBy('user')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    <span class="flex items-center gap-2">
                                        {{ __('trainings.th.user') }}
                                        @svg('feather-user', 'w-3 h-3')
                                    </span>

                                    @if($sortField === 'user')
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
                            @endif

                            @if($visibleColumns['planned_date'] ?? $defaultColumns['planned_date'])
                            <th wire:click="sortBy('planned_date')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    <span class="flex items-center gap-2">
                                        {{ __('trainings.th.planned_date') }}
                                        @svg('feather-calendar', 'w-3 h-3')
                                    </span>

                                    @if($sortField === 'planned_date')
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
                            @endif

                            @if($visibleColumns['planned_cost'] ?? $defaultColumns['planned_cost'])
                            <th wire:click="sortBy('planned_cost')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    {{ __('trainings.th.planned_cost') }}

                                    @if($sortField === 'planned_cost')
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
                            @endif

                            @if($visibleColumns['type'] ?? $defaultColumns['type'])
                            <th wire:click="sortBy('type')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    <span class="flex items-center gap-2">
                                        {{ __('trainings.th.type') }}
                                        @svg('feather-tag', 'w-3 h-3')
                                    </span>

                                    @if($sortField === 'type')
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
                            @endif

                            @if($visibleColumns['status'] ?? $defaultColumns['status'])
                            <th wire:click="sortBy('status')" scope="col" class="px-4 py-3 cursor-pointer">
                                <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                    <span class="flex items-center gap-2">
                                        {{ __('trainings.th.status') }}
                                        @svg('feather-git-commit', 'w-3 h-3')
                                    </span>

                                    @if($sortField === 'status')
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
                            @endif

                            @if($visibleColumns['actions'] ?? $defaultColumns['actions'])
                            <th class="px-4 py-3 w-48 text-center">
                                {{ __('common.th.actions') }}
                            </th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($models as $model)
                            <tr id="model-row-{{ $model->id }}" data-row-id="{{ $model->id }}" @class([
                                    'border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600',
                                    'text-gray-900 dark:text-gray-100',
                                ])
                            >
                                @if($visibleColumns['id'] ?? $defaultColumns['id'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $model->id }}
                                </td>
                                @endif

                                @if($visibleColumns['title'] ?? $defaultColumns['title'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $model->title }}
                                </td>
                                @endif

                                @if($visibleColumns['provider'] ?? $defaultColumns['provider'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $model->provider->name }}
                                </td>
                                @endif

                                @if($visibleColumns['user'] ?? $defaultColumns['user'])
                                <td class="px-4 py-3">{{ $model->user->full_name }}</td>
                                @endif

                                @if($visibleColumns['planned_date'] ?? $defaultColumns['planned_date'])
                                <td class="px-4 py-3">{{ $model->fiscal_date }}</td>
                                @endif

                                @if($visibleColumns['planned_cost'] ?? $defaultColumns['planned_cost'])
                                <td class="px-4 py-3 text-right pr-4">
                                    {{ Number::format($model->planned_cost, locale: app()->getLocale()) }}
                                </td>
                                @endif

                                @if($visibleColumns['type'] ?? $defaultColumns['type'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $model->type->label() }}
                                </td>
                                @endif

                                @if($visibleColumns['status'] ?? $defaultColumns['status'])
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-3 w-3 rounded-full mr-2" style="background-color: {{ $model->status->color() }};"></div>
                                        {{ $model->status->label() }}
                                    </div>
                                </td>
                                @endif

                                @if($visibleColumns['actions'] ?? $defaultColumns['actions'])
                                <td class="px-4 py-3 text-center justify-end content-center text-center">
                                    @can('markAsRealized', $model)
                                        @if($model->status->isPlanned())
                                        <a href="#mark-realized" wire:click="markAsRealized({{ $model->id }})" wire:confirm="{{ __('trainings.status.mark_as_realized_prompt') }}"
                                            class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                            data-tooltip-target="tooltip-mark-realized-{{ $model->id }}"
                                        >
                                            @svg('ffar-calendar-check', 'w-5 h-5', ['style' => 'color: '. App\Enums\TrainingStatus::REALIZED->color() ])
                                        </a>
                                        {{-- <x-tooltip id="tooltip-mark-realized-{{ $model->id }}" placement="bottom">
                                            {{ __('trainings.actions.mark_as_realized_tooltip') }}
                                        </x-tooltip> --}}
                                        @endif
                                    @endcan

                                    @can('trainingEvaluate', $model)
                                        <a href="{{ route('trainings.evaluation', $model->id) }}"
                                            class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                            data-tooltip-target="tooltip-training-evaluate-{{ $model->id }}"
                                        >
                                            @svg('far-star', 'w-5 h-5', ['style' => 'color: '. App\Enums\TrainingStatus::TRAINING_EVALUATED->color()])
                                        </a>
                                        {{-- <x-tooltip id="tooltip-training-evaluate-{{ $model->id }}" placement="bottom">
                                            {{ __('trainings.actions.training_evaluate_tooltip') }}
                                        </x-tooltip> --}}
                                    @endcan

                                    @can('effectivenessEvaluate', $model)
                                        <a href="{{ route('trainings.effectiveness', $model->id) }}"
                                            class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                            data-tooltip-target="tooltip-effectiveness-evaluate-{{ $model->id }}"
                                        >
                                            @svg('fas-list-check', 'w-5 h-5', ['style' => 'color: '. App\Enums\TrainingStatus::EFFECTIVENESS_EVALUATED->color()])
                                        </a>
                                        {{-- <x-tooltip id="tooltip-effectiveness-evaluate-{{ $model->id }}" placement="bottom">
                                            {{ __('trainings.actions.effectiveness_evaluate_tooltip') }}
                                        </x-tooltip> --}}
                                    @endcan

                                    <a href="{{ route('trainings.details', $model->id) }}"
                                        class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                    >
                                        @svg('feather-file-text', 'w-5 h-5')
                                        {{-- {{ __('table.actions.details') }} --}}
                                    </a>

                                    @can('update', $model)
                                    <a href="{{ route('trainings.edit', $model->id) }}"
                                        class="inline-flex items-center py-2 px-2 text-sm font-medium rounded-lg hover:bg-gray-200 dark:text-primary-500 dark:hover:bg-gray-800"
                                    >
                                        @svg('feather-edit', 'w-5 h-5')
                                        {{-- {{ __('table.actions.edit') }} --}}
                                    </a>
                                    @endcan
                                </td>
                                @endif
                            </tr>
                            {{--
                            <tr data-parent-row-id="model-row-{{ $model->id }}" @class([
                                    'border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600',
                                    'text-gray-900 dark:text-gray-100 hidden',
                                ])
                            >
                                <td colspan="8" class="px-4 py-3 text-right">
                                    <x-button.outline wire:click="openPreviewDrawer({{ $model->id }})" class="me-2">
                                        @svg('feather-file-text', 'w-3 h-3 mr-1')
                                        {{ __('table.actions.view') }}
                                    </x-button.outline>

                                    <a href="{{ route('trainings.details', $model->id) }}" type="button"
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                        @svg('heroicon-s-magnifying-glass', 'w-3 h-3 mr-1')
                                        {{ __('table.actions.details') }}
                                    </a>

                                    @can('update', $model)
                                    <x-button.outline wire:click="openEditModal({{ $model->id }})" class="me-2">
                                        @svg('feather-edit', 'w-3 h-3 mr-1')
                                        {{ __('table.actions.edit') }}
                                    </x-button.outline>
                                    @endcan

                                    @can('submitForApproval', $model)
                                        <x-button.outline wire:click="submitForApproval({{ $model->id }})"
                                            wire:confirm="Are you sure you want to submit this Training?" class="border-green-300 text-green-700 hover:bg-green-50 me-2">
                                            @svg('feather-thumbs-up', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.submit_for_approval') }}
                                        </x-button.outline>
                                    @endcan

                                    @can('dmApprove', $model)
                                        <x-button.outline wire:click="dmApprove({{ $model->id }})"
                                            wire:confirm="Are you sure you want to approve this Training?" class="border-green-300 text-green-700 hover:bg-green-50 me-2">
                                            @svg('feather-thumbs-up', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.dm_approve') }}
                                        </x-button.outline>
                                    @endcan

                                    @can('hrApprove', $model)
                                        <x-button.outline wire:click="hrApprove({{ $model->id }})"
                                            wire:confirm="Are you sure you want to approve this Training?" class="border-green-300 text-green-700 hover:bg-green-50 me-2">
                                            @svg('feather-thumbs-up', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.hr_approve') }}
                                        </x-button.outline>
                                    @endcan

                                    @can('ficoApprove', $model)
                                        <x-button.outline wire:click="ficoApprove({{ $model->id }})"
                                            wire:confirm="Are you sure you want to approve this Training?" class="border-green-300 text-green-700 hover:bg-green-50 me-2">
                                            @svg('feather-thumbs-up', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.fico_approve') }}
                                        </x-button.outline>
                                    @endcan

                                    @can('pmApprove', $model)
                                        <x-button.outline wire:click="pmApprove({{ $model->id }})"
                                            wire:confirm="Are you sure you want to approve this Training?" class="border-green-300 text-green-700 hover:bg-green-50 me-2">
                                            @svg('feather-thumbs-up', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.pm_approve') }}
                                        </x-button.outline>
                                    @endcan

                                    @can('withdraw', $model)
                                        <x-button.outline wire:click="withdraw({{ $model->id }})"
                                            wire:confirm="Are you sure you want to withdraw this Training?" class="border-red-300 text-red-700 hover:bg-red-50 me-2">
                                            @svg('feather-trash-2', 'w-3 h-3 mr-1')
                                            {{ __('table.actions.withdraw') }}
                                        </x-button.outline>
                                    @endcan
                                </td>
                            </tr> --}}
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Brak szkoleń</h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        @if($search)
                                            Nie znaleziono szkoleń dla frazy "{{ $search }}"
                                        @else
                                            Zacznij od dodania nowego szkolenia.
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

                    <!-- Paginacja -->
                    @if($models->hasPages())
                        <div class="bg-white px-4 py-3">
                            {{ $models->onEachSide(5)->links() }}
                        </div>
                    @endif

                    @can('import', Training::class)
                    <x-drawer id="import-trainings-drawer" title="Import Trainings">
                        @includeIf('trainings.partials.drawer-import')
                    </x-drawer>
                    @endCan

                    <x-drawer id="export-trainings-drawer" title="Export Trainings">
                        @includeIf('trainings.partials.drawer-export')
                    </x-drawer>

                    <x-drawer id="columns-drawer" title="Columns Settings">
                        @includeIf('trainings.partials.drawer-columns')
                    </x-drawer>

                    <div x-data="notifications()" x-init="$watch('show', value => { if (value) showAlert() })">
                        {{-- Globalny listener na notify --}}
                        <div x-data x-show="false"
                            x-on:import-notify.window="handleNotification($event.detail)"
                        ></div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>


@push('scripts')

    <script>
        function notifications() {
            return {
                show: false,
                type: '',
                title: '',
                message: '',
                icon: '',   // success, error, warning, info, question
                errors: {},

                handleNotification(detail) {
                    this.type = detail.type;
                    this.title = detail.title;
                    this.message = detail.message;
                    this.errors = detail.errors || {};
                    this.show = true;
                },

                showAlert() {
                    const icon = {
                        success: '✅',
                        error: '❌',
                        warning: '⚠️'
                    }[this.type] || 'ℹ️';

                    let html = `
                        <div class="flex items-center space-x-3">
                            <span>${icon}</span>
                            <div>
                                <h3 class="font-bold">${this.title}</h3>
                                <p>${this.message}</p>
                    `;

                    // Jeśli są błędy walidacji, pokaż je
                    if (Object.keys(this.errors).length) {
                        html += '<ul class="mt-2 list-disc list-inside text-sm text-red-700">';
                        Object.values(this.errors).flat().forEach(error => {
                            html += `<li>${error}</li>`;
                        });
                        html += '</ul>';
                    }

                    html += '</div></div>';

Swal.fire({
  icon: "error",
  title: "Oops...",
  text: "Something went wrong!",
  footer: '<a href="#">Why do I have this issue?</a>'
});


                    Swal.fire({
                        html: html,
                        iconHtml: icon,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'animate__animated animate__fadeInRight',
                            timerProgressBar: 'bg-' + this.type
                        }
                    }).then(() => {
                        this.show = false;
                    });
                }
            }
        }
    </script>

    <script>
        // hideImportDrawer() {
        //     const importDrawer = document.getElementById('import-drawer');
        //         if (!importDrawer.contains(e.target) && !e.target.closest('[data-drawer-target="import-drawer"]')) {
        //             importDrawer.classList.add('translate-x-full');
        //             document.body.classList.remove('overflow-hidden');
        //             importDrawer.setAttribute('aria-hidden', 'true');
        //         }
        // }
                // Handle import drawer toggle
        document.addEventListener('livewire:initialized', () => {
            // Show import drawer
            // Livewire.on('show-import-drawer', () => {
            //     const importDrawer = document.getElementById('import-drawer');
            //     importDrawer.classList.remove('translate-x-full');
            //     document.body.classList.add('overflow-hidden');
            //     importDrawer.setAttribute('aria-hidden', 'false');
            // });

            // // Show export drawer
            // Livewire.on('show-export-drawer', () => {
            //     const exportDrawer = document.getElementById('export-drawer');
            //     exportDrawer.classList.remove('translate-x-full');
            //     document.body.classList.add('overflow-hidden');
            //     exportDrawer.setAttribute('aria-hidden', 'false');
            // });

            // Close drawer when clicking outside
            document.addEventListener('click', (e) => {
                // const importDrawer = document.getElementById('import-drawer');
                // const exportDrawer = document.getElementById('export-drawer');

                // if (!importDrawer.contains(e.target) && !e.target.closest('[data-drawer-target="import-drawer"]')) {
                //     importDrawer.classList.add('translate-x-full');
                //     document.body.classList.remove('overflow-hidden');
                //     importDrawer.setAttribute('aria-hidden', 'true');
                // }

                // if (!exportDrawer.contains(e.target) && !e.target.closest('[data-drawer-target="export-drawer"]')) {
                //     exportDrawer.classList.add('translate-x-full');
                //     document.body.classList.remove('overflow-hidden');
                //     exportDrawer.setAttribute('aria-hidden', 'true');
                // }
            });
        });

        // Close drawer when clicking the close button
        document.addEventListener('click', (e) => {
            if (e.target.closest('[data-drawer-hide]')) {
                const drawerId = e.target.closest('[data-drawer-hide]').getAttribute('data-drawer-hide');
                const drawer = document.getElementById(drawerId);
                if (drawer) {
                    drawer.classList.add('translate-x-full');
                    document.body.classList.remove('overflow-hidden');
                    drawer.setAttribute('aria-hidden', 'true');
                }
            }
        });


window.addEventListener('swal:modal', event => {
    Swal.fire({
        title: event.detail.title ?? null,
        text: event.detail.text ?? null,
        icon: event.detail.type ?? 'info',
    });
});

        // window.addEventListener('swal:confirm', event => {
        //     swal({
        //     title: event.detail.message,
        //     text: event.detail.text,
        //     icon: event.detail.type,
        //     buttons: true,
        //     dangerMode: true,
        //     })
        //     .then((willDelete) => {
        //     if (willDelete) {
        //         window.livewire.emit('remove');
        //     }
        //     });
        // });

    </script>
@endpush
