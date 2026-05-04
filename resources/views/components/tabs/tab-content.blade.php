@props([
    'name'  => str()->random(5),
])
<div class="hidden p-4 rounded-base bg-neutral-secondary-soft" id="tab-{{ $name }}-content" role="tabpanel" aria-labelledby="{{ $name }}-tab">
    {{ $slot }}
</div>
