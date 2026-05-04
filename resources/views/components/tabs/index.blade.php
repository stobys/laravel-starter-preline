@props([
    'name' => str()->random(5),
])

<div class="mb-4">
    <ul role="tablist" id="{{ $name }}-tab"
        class="flex flex-wrap -mb-px text-sm font-medium text-center" 
        data-tabs-toggle="#{{ $name }}-tab-content" 
        data-tabs-active-classes="font-bold text-text-adient-teal-1 hover:text-adient-teal-1 dark:text-adient-green-1 dark:hover:text-adient-green-1 border-b-2 border-adient-teal-1 dark:border-adient-green-1" 
        data-tabs-inactive-classes="border-transparent text-gray-300 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
    >
        {{ $slot }}
    </ul>
</div>
<div id="{{ $name }}-tab-content">
    {{ $content }}
</div>
