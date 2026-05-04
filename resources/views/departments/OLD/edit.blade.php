@extends('layout.flowbite.app')

@section('content')
    <section>
        <x-form action="{{ route('departments.update', $department->id) }}">
            @method('PATCH')
        <div class="mx-auto w-full shadow-sm rounded-lg mb-4 border border-gray-200 dark:border-gray-700">
            <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex-row items-center justify-between p-4 sm:flex sm:space-y-0 sm:space-x-4 border-b border-gray-200 dark:border-gray-700">
                    <div>
                        <h5 class="mr-3 font-semibold dark:text-gray-300">Department Edit</h5>
                        <p class="text-adient-teal-3 dark:text-gray-400 text-sm">Update required information</p>
                    </div>

                    <div class="inline-flex">
                        <button type="submit" class="btn-success">
                            @svg('heroicon-s-paper-airplane', 'w-4 h-4 mr-2 -rotate-45')
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <div class="p-4 mb-4 bg-white 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        <h3 class="mb-4 text-xl font-semibold dark:text-white">General information</h3>
                        <x-form.row class="mb-6">
                            <x-form.field-group name="name" :label="__('Name')" class="md:w-1/3">
                                <input type="text" name="name" id="name" placeholder="Enter Name" value="{{ old('name', $department->name) }}"
                                    @class([
                                        'block w-full p-3 mb-3 rounded-lg sm:text-sm border',
                                        'text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500',
                                        'dark:placeholder-gray-400  dark:focus:ring-primary-500 dark:focus:border-primary-500',
                                        'border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700' => !$errors->has('name'),
                                        'border-red-500 dark:border-red-500 bg-red-100 dark:bg-red-700' => $errors->has('name'),
                                    ])
                                >
                            </x-form.field-group>
                            <x-form.field-group name="abbr" :label="__('Abbereviation')" class="md:w-1/3">
                                <input type="text" name="abbr" id="abbr" placeholder="Enter Abbreviation" value="{{ old('abbr', $department->abbr) }}"
                                    @class([
                                        'block w-full p-3 mb-3 rounded-lg sm:text-sm border',
                                        'text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500',
                                        'dark:placeholder-gray-400  dark:focus:ring-primary-500 dark:focus:border-primary-500',
                                        'border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700' => !$errors->has('abbr'),
                                        'border-red-500 dark:border-red-500 bg-red-100 dark:bg-red-700' => $errors->has('abbr'),
                                    ])
                                >
                            </x-form.field-group>
                            <x-form.field-group name="manager_id" :label="__('Manager')" class="md:w-1/3">
                                <input type="text" name="manager_id" id="manager_id" placeholder="Choose Manager" value="{{ old('manager_id', $department->manager_id) }}"
                                    @class([
                                        'block w-full p-3 mb-3 rounded-lg sm:text-sm border',
                                        'text-gray-900 dark:text-white focus:ring-primary-500 focus:border-primary-500',
                                        'dark:placeholder-gray-400  dark:focus:ring-primary-500 dark:focus:border-primary-500',
                                        'border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700' => !$errors->has('manager_id'),
                                        'border-red-500 dark:border-red-500 bg-red-100 dark:bg-red-700' => $errors->has('manager_id'),
                                    ])
                                >
                            </x-form.field-group>
                        </x-form.row>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="flex-row items-center justify-end p-4 sm:flex sm:space-y-0 sm:space-x-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="inline-flex">
                        <button type="submit" name="submit" value="submit" class="btn-success">
                            @svg('heroicon-s-paper-airplane', 'w-4 h-4 mr-2 -rotate-45')
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>

            </div>
        </div>
        </x-form>
    </section>

<div>




    <x-auth-session-status class="mb-4" :status="session('status')" />

</div>
@endsection

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

        });

    </script>
@endpush
