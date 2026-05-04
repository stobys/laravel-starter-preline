@extends('layout.main')

@section('content')
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Editor Test</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                This is a test page for the Livewire profile editor component.
            </p>
        </div>

        <div class="bg-white dark:bg-boxdark rounded-lg shadow">
            @livewire('profile-editor')
        </div>

        <div class="mt-8">
            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center text-sm font-medium text-primary hover:text-primary-dark dark:text-primary-400 dark:hover:text-primary-300"
            >
                <svg class="mr-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
                Back to Dashboard
            </a>
        </div>
    </div>
@endsection
