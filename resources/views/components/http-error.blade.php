@props([
    'code'  => null,
    'exception' => null,
    'codes' => [
        '401' => [
            'title' => 'Not Authorized',
            'message' => 'Oops. You need permission to access this.',
            'helper' => 'Please log in or contact your administrator for access.',
        ],
        '402' => [
            'title' => 'Payment Required',
            'message' => 'Oops. This feature requires an active subscription.',
            'helper' => 'Please update your payment details or upgrade your plan.',
        ],
        '403' => [
            'title' => 'Access Forbidden',
            'message' => 'Access Forbidden',
            'helper' => 'Your account lacks the necessary privileges. Contact support.',
        ],
        '404' => [
            'title' => 'Page Not Found',
            'message' => 'Oops. You don\'t have permission to view this page.',
            'helper' => 'You may have mistyped the address or the page may have moved.',
        ],
        '419' => [
            'title' => 'Page Expired',
            'message' => 'Oops. This page has expired and is no longer valid.',
            'helper' => 'Please refresh the page or go back and try again.',
        ],
        '429' => [
            'title' => 'Too Many Requests',
            'message' => 'Oops. You\'re sending requests too quickly.',
            'helper' => ' Please wait a moment before trying again.',
        ],
        '500' => [
            'title' => 'Server Error',
            'message' => 'Something went wrong on our end.',
            'helper' => 'We\'re working to fix this. Please try again shortly.',
        ],
        '503' => [
            'title' => 'Service Unavailable',
            'message' => 'Oops. The service is temporarily down.',
            'helper' => ' Please check back in a few minutes.',
        ],
    ],
])

<div class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 border-b border-card-line">

    <div class="container mx-auto p-4 flex flex-wrap items-center">
        <div class="w-full md:w-7/12 text-center md:text-left p-12">
            <h1 class="block text-7xl font-bold text-foreground sm:text-9xl">#{{ $code }}</h1>
            <div class="text-5xl md:text-7xl font-medium mb-4">
                {{ $codes[$code]['title'] ?? null }}
            </div>
            <div class="text-xl md:text-3xl font-medium mt-8 mb-4">
                {{ $codes[$code]['message'] ?? null }}
            </div>
            <div class="text-lg mb-8">
                {{ $codes[$code]['helper'] ?? null }}
            </div>
            <a  href="{{ url('/') }}" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                <x-feather-chevron-left class="shrink-0 size-5" />
                {{ __('Go Home') }}
            </a>
        </div>
    </div>

    @if( config('app.debug', false) )
    <div class="container mx-auto p-4 flex items-center">
        <!-- Card -->
        <div class="flex flex-col bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 shadow-2xs rounded-xl">
            <div class="bg-gray-100 dark:bg-neutral-700 border-b border-gray-200 dark:border-neutral-700 rounded-t-xl py-3 px-4">
                <p class="text-sm text-gray-500 dark:text-neutral-400">
                    Exception : {{ $exception?->getFile() }}:{{ $exception?->getLine() }}
                </p>
            </div>
            <div class="p-4">
                <p class="mt-1 text-gray-500 dark:text-neutral-400">
                    {{ $exception?->getMessage() }}
                </p>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        {{-- <div class="flex flex-col bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 shadow-2xs rounded-xl">
            <div class="bg-gray-100 dark:bg-neutral-700 border-b border-gray-200 dark:border-neutral-700 rounded-t-xl py-3 px-4">
                <p class="text-sm text-gray-500 dark:text-neutral-400">
                    Exception Trace
                </p>
            </div>
            <div class="p-4">
                <p class="mt-1 text-gray-500 dark:text-neutral-400">
                    <pre>{{ $exception?->getTraceAsString() }}</pre>
                </pre>
            </div>
        </div> --}}
        <!-- End Card -->
    </div>
    @endif
</div>
