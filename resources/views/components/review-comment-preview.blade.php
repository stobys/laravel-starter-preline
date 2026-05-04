@props([
    'value' => null,
    'name'  => Str::random(8),
    'class' => 'flex flex-wrap items-center py-4 hover:bg-gray-100',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="w-full flex space-between px-1 md:w-7/12">
        {{ $slot }}
    </div>
    <div class="w-full px-1 md:w-5/12 text-justify">
        {{ $value }}
    </div>
</div>
