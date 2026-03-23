@props([
    'href' => '#',
    'text' => null,
    'active' => null,
])

<li>
    <a href="{{ $href }}" @class([
        "w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-sidebar-2-nav-foreground rounded-lg hover:bg-sidebar-2-nav-hover focus:outline-hidden focus:bg-sidebar-2-nav-focus",
        "border-s-2 border-gray-400 bg-gray-100 dark:bg-gray-800" => $active,
    ])>
        {{ $slot }} {{ $text }}
    </a>
</li>
