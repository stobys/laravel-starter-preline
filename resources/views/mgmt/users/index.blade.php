@extends('layout.main')

@section('content')

    <!-- Content -->
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
                                        @includeIf('mgmt.users.index-filter')
                                    </div>
                                </x-form>
                                <!-- End Header -->

                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <x-table.thead>
                                            <th scope="col" class="ps-6 py-3 text-start">
                                                <label for="hs-at-with-checkboxes-main" class="flex">
                                                    <input type="checkbox" class="shrink-0 size-4 bg-transparent border-gray-300 dark:border-neutral-600 rounded-sm shadow-2xs text-gray-800 dark:text-white focus:ring-0 focus:ring-offset-0 checked:bg-gray-800 dark:checked:bg-white checked:border-gray-800 dark:checked:border-white disabled:opacity-50 disabled:pointer-events-none" id="hs-at-with-checkboxes-main">
                                                    <span class="sr-only">Checkbox</span>
                                                </label>
                                            </th>

                                            <x-table.th sortable model="user" sort-field="full_name">Name</x-table.th>
                                            <x-table.th>Roles</x-table.th>
                                            <x-table.th>Status</x-table.th>
                                            <x-table.th>Password Age</x-table.th>
                                            <x-table.th sortable model="user" sort-field="created_at">Created At</x-table.th>
                                            <x-table.th></x-table.th>
                                    </x-table.thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        @foreach($users as $user)
                                            @includeIf('mgmt.users.index-row', ['user' => $user])
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->

                                <!-- Footer -->
                                @if( $users->hasPages() )
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                                        {{ $users->appends(request()->query())->links() }}
                                    </div>
                                @endif
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
    <!-- End Content -->

@endsection
