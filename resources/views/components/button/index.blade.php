@blaze

@props([
    'size'  => 'md',
    'color' => 'primary',
])

@php
    $sizes = [
        'xs' => 'px-2 py-1 font-small',
        'sm' => 'px-3 py-2 font-small',
        'md' => 'px-3 py-2 font-small',
        'lg' => 'px-6 py-3 font-medium',
    ];

    $sizeClass = match($size) {
        'xs', 'sm', 'md', 'lg' => $sizes[$size],
        default => $sizes['md']
    };

    $colors = [
        'adient'    => 'bg-adient-teal-1 hover:bg-adient-teal-2 text-adient-green-1 hover:text-adient-green-2',
        'primary'   => 'bg-blue-600 hover:bg-blue-700 text-white',
        'success'   => 'bg-green-600 hover:bg-green-700 text-white',
        'warning'   => 'bg-orange-600 hover:bg-orange-700 text-white',
        'danger'    => 'bg-red-600 hover:bg-red-700 text-white',
        'info'      => 'bg-blue-600 hover:bg-blue-700 text-white',
        // 'outline'   => 'bg-white hover:bg-gray-50 text-gray-700',
    ];

    $colorClass = match($color) {
        'success', 'warning', 'danger', 'info', 'adient' => $colors[$color],
        default => $colors['primary']
    };
@endphp

<button {{ $attributes->merge(['class' => 'inline-flex items-center shadow-sm '. $sizeClass .' '. $colorClass .'  border border-transparent rounded-lg  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200']) }}>
    {{ $slot }}
</button>
{{--
INDEX   : bg-blue-600  border-transparent rounded-lg font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200
PRIMARY : bg-gray-800 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150
OUTLINE : border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150
--}}
