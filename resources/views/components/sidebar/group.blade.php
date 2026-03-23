@props([
    'title' => 'GROUP',
])

<div class="pt-3 mt-3 flex flex-col border-t border-sidebar-2-divider first:border-t-0 first:pt-0 first:mt-0">
    <span class="block ps-2.5 mb-2 font-medium text-xs uppercase text-muted-foreground-1">
        // -- {{  $title }}
    </span>

    <!-- List -->
    <ul class="flex flex-col gap-y-1">
        {{ $slot }}
    </ul>
    <!-- End List -->
</div>
