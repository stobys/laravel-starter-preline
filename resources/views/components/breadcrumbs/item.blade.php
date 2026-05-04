@props(['text' => 'Title', 'href' => '#'])

<li>
    <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ $href }}">
        {{ $text }}
        @svg('feather-chevron-right', 'w-4 h-4')
    </a>
</li>
