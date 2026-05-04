@extends('layout.main')

@section('content')

    <!-- Content -->
        <!-- Header -->
        <div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ __('delegations.labels.index-title') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-300">
                    {{ __('delegations.labels.index-title-helper') }}
                </p>
            </div>

            <!-- Button Group -->
            <div class="flex items-center gap-x-2">
                <a href="{{ route('users.delegations.create') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                    <x-feather-user-plus class="shrink-0 size-4" />
                    {{ __('delegations.actions.add-new') }}
                </a>
            </div>
            <!-- End Button Group -->
        </div>
        <!-- End Header -->

        <!-- Body -->
        <div class="flex-1 flex flex-col overflow-hidden overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-scrollbar-track [&::-webkit-scrollbar-thumb]:bg-scrollbar-thumb">
            <!-- Table Section -->
            <div class="px-6 py-6 grid grid-cols-1 xl:grid-cols-2 gap-2.5">
                <!-- Card -->
                <div class="flex flex-col">
					<div class="bg-surface border-b border-card-line rounded-t-xl py-3 px-4">
						<p class="text-sm text-muted-foreground-1">
							{{ __('delegations.labels.outgoing') }} - user give permission to others
						</p>
					</div>
                    <div class="overflow-x-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                        <div class="min-w-full inline-block align-middle">
                            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-b-xl shadow-2xs overflow-hidden">
                                <!-- Header -->
                                <x-form action="{{ route('users.delegations.filter') }}">
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-table-line">
                                        @includeIf('mgmt.delegations.index-filter')
                                    </div>
                                </x-form>
                                <!-- End Header -->

                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <x-table.thead>
                                            <x-table.th>{{ __('delegations.th.delegate') }}</x-table.th>
											<x-table.th>{{ __('delegations.th.valid_from') }}</x-table.th>
                                            <x-table.th>{{ __('delegations.th.valid_to') }}</x-table.th>
                                            <x-table.th>{{ __('app.th.actions') }}</x-table.th>
                                    </x-table.thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
										{{-- user give permission to others --}}
                                        @foreach($outgoing as $delegation)
                                            @includeIf('mgmt.delegations.index-row', ['delegation' => $delegation, 'dir' => 'outgoing'])
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->

                                <!-- Footer -->
                                @if( $outgoing->hasPages() )
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                                        {{ $outgoing->appends(request()->query())->links() }}
                                    </div>
                                @endif
                                <!-- End Footer -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="flex flex-col">
					<div class="bg-surface border-b border-card-line rounded-t-xl py-3 px-4">
						<p class="text-sm text-muted-foreground-1">
							{{ __('delegations.labels.incoming') }} - others give permission to user
						</p>
					</div>
                    <div class="overflow-x-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-none [&::-webkit-scrollbar-track]:bg-gray-100 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                        <div class="min-w-full inline-block align-middle">
                            <div class="bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 rounded-b-xl shadow-2xs overflow-hidden">
                                <!-- Header -->
                                <x-form action="{{ route('users.delegations.filter') }}">
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-table-line">
                                        @includeIf('mgmt.delegations.index-filter')
                                    </div>
                                </x-form>
                                <!-- End Header -->

                                <!-- Table -->
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <x-table.thead>
                                            <x-table.th>{{ __('delegations.th.delegator') }}</x-table.th>
											<x-table.th>{{ __('delegations.th.valid_from') }}</x-table.th>
                                            <x-table.th>{{ __('delegations.th.valid_to') }}</x-table.th>
                                            <x-table.th>{{ __('app.th.actions') }}</x-table.th>
                                    </x-table.thead>

                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
										{{-- others give permission to user --}}
                                        @foreach($incoming as $delegation)
                                            @includeIf('mgmt.delegations.index-row', ['delegation' => $delegation, 'dir' => 'incoming'])
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table -->

                                <!-- Footer -->
                                @if( $incoming->hasPages() )
                                    <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                                        {{ $incoming->appends(request()->query())->links() }}
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
