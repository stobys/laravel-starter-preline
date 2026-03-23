@extends('layout.main')

@section('content')

    <!-- Content -->
    <div class="h-[calc(100dvh-62px)] lg:h-full overflow-hidden flex flex-col bg-layer border border-layer-line shadow-xs rounded-lg">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <!-- Header -->
            <div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                        Users
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-neutral-300">
                        Edit form.
                    </p>
                </div>

                <!-- Button Group -->
                <div class="flex items-center gap-x-2">
                    <a  href="{{ route('users.index') }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
                        <x-feather-x-circle class="shrink-0 size-4" />
                        Cancel
                    </a>

                    @if($user->trashed())
                    <a  href="{{ route('users.restore', $user->id) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg text-orange-600 dark:text-orange-600 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:text-orange-500 dark:hover:text-orange-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
                        <x-feather-trash class="shrink-0 size-4" />
                        Restore
                    </a>
                    @else
                    <a  href="{{ route('users.delete', $user->id) }}" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg text-red-600 dark:text-red-600 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:text-red-500 dark:hover:text-red-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700">
                        <x-feather-trash-2 class="shrink-0 size-4" />
                        Delete
                    </a>
                    @endif

                    <button type="submit" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-green-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-green-700 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                        <x-feather-save class="shrink-0 size-4" />
                        Update
                    </button>
                </div>
                <!-- End Button Group -->
            </div>
            <!-- End Header -->

            <!-- Table Section -->
            <div class="w-full mx-auto">
                @includeIf('mgmt.users.user-form', ['user' => $user])
            </div>
            <!-- End Table Section -->

            @if($errors->any())
                <div class="w-full mx-auto">
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Validation Error!</strong>
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </form>
    </div>
    <!-- End Content -->

@endsection
