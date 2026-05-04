@props(['text' => 'Title'])

<nav {{ $attributes }}>
    <ol class="flex justify-center items-center gap-1.5">
        <li>
            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ url('/') }}">
                @svg('feather-home', 'w-4 h-4')
                @svg('feather-chevron-right', 'w-4 h-4')
            </a>
        </li>
        {{ $slot }}
        <li class="text-sm text-gray-800 dark:text-white/90">{{ $text }}</li>
    </ol>
</nav>
