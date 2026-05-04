@props([
    'id' => 'drawer-'. Str::random(4),
    'title' => 'Drawer Title',
])

<div data-drawer-name="{{ $id }}" x-data="{ open: false }"
    @drawer-toggle.window="if ($event.detail.name === $el.dataset.drawerName) { open = !open; }"
    @drawer-show.window="if ($event.detail.name === $el.dataset.drawerName) { open = true; }"
    @drawer-hide.window="if ($event.detail.name === $el.dataset.drawerName) { open = false; }"
>
    <!-- Backdrop -->
    <div x-show="open" @click="open = false"
        x-transition.opacity
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"
    ></div>

    <!-- Drawer -->
    <div
        x-show="open"
        x-transition.duration.300ms
        class="fixed right-0 top-0 h-full w-80 bg-white shadow-xl p-4 z-50"
    >
        <div class="flex justify-between items-center mb-4 pb-2 border-b border-default">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
            <button @click="open = false" class="text-xl">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
            </button>
        </div>
        <div>
            {{ $slot }}
        </div>
    </div>


</div>

{{-- <!-- drawer component -->
<div id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}"
    {{ $attributes->merge(['class' => 'fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-gray-50 border-e border-default w-80']) }}
>
    <div class="border-b border-default pb-4 flex items-center">
        <h5 id="drawer-label-contact" class="inline-flex items-center text-lg font-medium text-body">
            <svg class="w-5 h-5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.283 8h-4.285m3.85 3h-3.85m4.061-6H11v11h8.27l1.715-9.847A.983.983 0 0 0 20.059 5ZM6.581 13.23h-.838A13.752 13.752 0 0 1 5.622 11c-.02-.745.02-1.49.12-2.23h1.04c.252 0 .496-.088.683-.245a.927.927 0 0 0 .329-.61l.2-1.872a.888.888 0 0 0-.045-.39.936.936 0 0 0-.212-.34 1.017 1.017 0 0 0-.341-.231A1.08 1.08 0 0 0 6.983 5h-2.06a1.27 1.27 0 0 0-.699.204 1.135 1.135 0 0 0-.442.543A15.066 15.066 0 0 0 3.007 11a15.656 15.656 0 0 0 .795 5.229c.165.462 1.342.771 1.864.771h1.116c.142 0 .283-.028.413-.082.13-.053.246-.132.341-.23a.936.936 0 0 0 .212-.34.889.889 0 0 0 .046-.391l-.201-1.873a.927.927 0 0 0-.33-.609 1.059 1.059 0 0 0-.682-.245ZM10 18v1h10v-1a2 2 0 0 0-2-2h-6a2 2 0 0 0-2 2Z"/></svg>
            {{ $title }}
        </h5>
        <button type="button" data-drawer-hide="{{ $id }}" aria-controls="{{ $id }}" class="text-body bg-transparent hover:text-heading hover:bg-neutral-tertiary rounded-base w-9 h-9 absolute top-2.5 end-2.5 flex items-center justify-center">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
            <span class="sr-only">Close menu</span>
        </button>

        <button type="button" data-drawer-hide="{{ $id }}-backdrop" aria-controls="{{ $id }}-backdrop" class="text-body bg-transparent hover:text-heading hover:bg-neutral-tertiary rounded-base w-9 h-9 absolute top-2.5 end-2.5 flex items-center justify-center">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"/></svg>
            <span class="sr-only">Close menu</span>
        </button>
    </div>
    <div class="py-5 overflow-y-auto">
        {{ $slot }}
    </div>
</div> --}}
