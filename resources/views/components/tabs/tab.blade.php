@props([
    'name' => str()->random(5),
    'active' => false,
])

<li class="me-2" role="presentation">
    <a href="#" @class(['inline-flex items-center justify-center p-4 border-b-2 rounded-t-base',
        'hover:text-fg-adient-teal-1 hover:border-adient-teal-1 group',
        'text-fg-adient-teal-1 border-adient-teal-1' => $active,
        'text-gray-500 border-transparent' => !$active,
        ]) 
        
        id="{{ $name }}-styled-tab" data-tabs-target="#tab-{{ $name }}-content" type="button" role="tab" aria-controls="{{ $name }}" aria-selected="{{ $active ? 'true' : 'false' }}"
    >
        {{ $slot }}
    </a>
</li>
