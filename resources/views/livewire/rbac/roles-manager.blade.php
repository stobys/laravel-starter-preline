<div>
    <!-- Tabela -->
    <section>
        <div class="mx-auto w-full shadow-sm rounded-lg mb-4 border border-gray-200 dark:border-gray-700">
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex-row items-center justify-between p-4 sm:flex sm:space-y-0 sm:space-x-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h5 class="mr-3 font-semibold dark:text-gray-300">Role Based Access Control : Roles</h5>
                        <p class="text-adient-teal-3 dark:text-gray-400 text-sm">Manage all your existing roles or add a new one</p>
                    </div>
                    <button type="button" wire:click="openCreateModal()"
                        bg-new="adient-teal-1" bg-old="bg-primary-700"
                        class="flex items-center justify-center px-4 py-2 text-sm font-medium rounded-lg focus:ring-4 focus:ring-primary-300 focus:outline-none dark:focus:ring-primary-800
                            border-gray-500
                            bg-adient-teal-1 hover:bg-adient-teal-2 text-adient-green-1
                            dark:bg-adient-green-1 dark:hover:bg-adient-green-2 dark:text-adient-teal-1
                            dark:bg-primary-600 dark:hover:bg-primary-700
                    ">
                        @svg('feather-plus', 'w-4 h-4 mr-2')
                        Add new Role
                    </button>
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
                                    wire:model.live.debounce.300ms="search" placeholder="Szukaj ..."
                                >
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <div class="flex items-center space-x-3 w-full md:w-auto">
                            <div class="flex w-40 items-center col-span-2 ml-auto space-x-3 lg:col-span-1">
                                <select wire:model.live.debounce.300ms="active" class="hidden w-40 p-2 px-3 text-xs h-9 text-gray-900 bg-gray-100 border border-gray-300 rounded-lg cursor-pointer w-36 sm:block hover:bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder:text-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="1">Aktywne</option>
                                    <option value="2">Nieaktywne</option>
                                    <option value="4">Wszystkie</option>
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
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-400 opacity-70">
                            <tr>
                                <th scope="col" class="p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th wire:click="sortBy('name')" scope="col" class="px-4 py-3 cursor-pointer">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        Role

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
                                <th wire:click="sortBy('guard_name')" scope="col" class="px-4 py-3 cursor-pointer">
                                    <p class="antialiased flex items-center justify-between gap-2 leading-none">
                                        Guard

                                        @if($sortField === 'guard_name')
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
                                <th scope="col" class="px-4 py-3">Stats</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr @class([
                                    'border-b dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600',
                                    'text-gray-900 dark:text-gray-100' => !$role->trashed(),
                                    'text-red-900 dark:text-red-100 bg-red-50 dark:bg-red-50' => $role->trashed(),
                                ])
                            >
                                <td class="w-4 p-4">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $role->name }}
                                    {{-- <x-form.checkbox /> --}}
                                </td>
                                <td class="px-4 py-3">{{ $role->guard_name }}</td>
                                <td class="px-4 py-3">
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-sm me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-500 ">
                                            {{-- @svg('feather-users', 'w-3 h-3 mr-1') --}}
                                            Users :
                                            {{ $role->users_count }}
                                    </span>

                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-sm me-2 dark:bg-gray-700 dark:text-gray-400 border border-gray-500 ">
                                            {{-- @svg('feather-shield', 'w-3 h-3 mr-1')  --}}
                                            Permissions :
                                            {{ $role->permissions_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex items-center justify-end">
                                    @unless($role->is_system_role)
                                        <x-button.outline wire:click="openEditModal({{ $role->id }})" class="me-2">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            {{ __('table.actions.edit') }}
                                        </x-button.outline>
                                        @if( $role->trashed() )
                                            <x-button.outline wire:click="restoreRole({{ $role->id }})"
                                                wire:confirm="Are you sure you want to restore this user?" class="border-orange-300 text-orange-700 hover:bg-orange-50 me-2">
                                                @svg('feather-trash', 'w-4 h-4 mr-1')
                                                {{ __('table.actions.restore') }}
                                            </x-button.outline>
                                        @else
                                            <x-button.outline wire:click="deleteRole({{ $role->id }})"
                                                wire:confirm="Are you sure you want to delete this user?" class="border-red-300 text-red-700 hover:bg-red-50 me-2">
                                                @svg('feather-trash-2', 'w-4 h-4 mr-1')
                                                {{ __('table.actions.delete') }}
                                            </x-button.outline>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 mr-2 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ __('System Role') }}
                                        </span>
                                    @endunless

                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Brak ról</h3>
                                        <p class="mt-1 text-sm text-gray-500">
                                            @if($search)
                                                Nie znaleziono ról dla frazy "{{ $search }}"
                                            @else
                                                Zacznij od dodania nowej roli.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
                        <div class="flex">
                            <div class="shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-500 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-700 dark:text-white dark:border-gray-600">
                                Page Size
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
                        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                            Showing
                            <span class="font-semibold text-gray-900 dark:text-white">
                                1-10
                                /
                                Count : {{ $roles -> count() }}
                                /
                                Current Page : {{ $roles -> currentPage() }}
                            </span>
                            of
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $roles->total() }}
                            </span>
                        </span>

                        <!-- Paginacja -->
                        @if($roles->hasPages())
                            <div class="bg-white px-4 py-3 border-t border-gray-200">
                                {{ $roles->onEachSide(5)->links() }}
                            </div>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
        @includeIf('rbac.partials.role-modal')
    </section>




@push('scripts')
    <script>
        // function setActiveTab(tab) {
        //     window.livewire.set('activeTab', tab);
        //     // Update URL without page reload
        //     const url = new URL(window.location);
        //     url.searchParams.set('activeTab', tab);
        //     window.history.pushState({}, '', url);
        // }

        // Initialize active tab from URL
        document.addEventListener('livewire:initialized', () => {
            // window.addEventListener('open-modal', event => {
            //     // Znajdź przycisk pierwszej karty i symuluj kliknięcie
            //     const firstTab = document.getElementById('role-general-tab');
            //     if (firstTab) {
            //         firstTab.click();
            //     }
            // });

            // const urlParams = new URLSearchParams(window.location.search);
            // const activeTab = urlParams.get('activeTab');
            // if (activeTab) {
            //     window.livewire.set('activeTab', activeTab);
            // }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // const tabsElement = document.getElementById('role-tabs');
            // // create an array of objects with the id, trigger element (eg. button), and the content element
            // const tabElements = [
            //     {
            //         id: 'general',
            //         triggerEl: document.querySelector('#role-general-tab'),
            //         targetEl: document.querySelector('#role-general-content'),
            //     },
            //     {
            //         id: 'permissions',
            //         triggerEl: document.querySelector('#role-permissions-tab'),
            //         targetEl: document.querySelector('#role-permissions-content'),
            //     },
            // ];

            // // options with default values
            // const options = {
            //     defaultTabId: 'general',
            //     activeClasses:
            //         'text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-400 border-blue-600 dark:border-blue-500',
            //     inactiveClasses:
            //         'text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300',
            //     onShow: () => {
            //         console.log('tab is shown');
            //     },
            // };

            // // instance options with default values
            // const instanceOptions = {
            //     id: 'tabs-example',
            //     override: true
            // };

            // const tabs = new Tabs(tabsElement, tabElements, options, instanceOptions);
        });

    </script>
@endpush
