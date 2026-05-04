@props(['required' => false, 'text' => null])

<label {{ $attributes->merge(['class' => 'mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400']) }}>
    {{ empty(trim($slot)) ? $text : $slot}}
    @if($required)<span class="text-error-500">*</span>@endif
</label>
