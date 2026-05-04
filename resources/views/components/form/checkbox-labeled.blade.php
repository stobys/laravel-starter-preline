@props([
    'name' => str()->random(10),
    'id' => str()->random(10),
    'label' => 'Checkbox Label',
    'checked' => false,
    'value' => null,
    'wiremodel' => null,
])

@php
    $checked = $checked ? true : false;
@endphp

<div x-data="{ checkboxToggle: {{ $checked ? 'true' : 'false' }} }">
    <label for="{{ $id }}" class="flex items-start text-sm font-normal text-gray-700 cursor-pointer select-none dark:text-gray-400">
        <div class="relative">
            <input type="checkbox" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" class="sr-only"
                @if($wiremodel) wire:model="{{ $wiremodel }}" @endif
                @change="checkboxToggle = !checkboxToggle"
            />
            <div class="mr-3 flex h-5 w-5 items-center justify-center rounded-md border-[1.25px]"
                :class="checkboxToggle ? 'border-brand-500 bg-brand-500' : 'bg-transparent border-gray-300 dark:border-gray-700'"
            >
                <span :class="checkboxToggle ? '' : 'opacity-0'">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.6666 3.5L5.24992 9.91667L2.33325 7" stroke="white" stroke-width="1.94437" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
            </div>
        </div>
        <p class="inline-block font-normal text-gray-500 dark:text-gray-400">
            {{ empty(trim($slot)) ? $label : $slot}}
        </p>
    </label>
</div>
