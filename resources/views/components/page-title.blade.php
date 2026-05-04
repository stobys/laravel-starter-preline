@props(['title' => 'Title', 'breadcrumbs' => null])

<!-- Breadcrumb Start -->
<div>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">
            {{ $title }}
        </h2>

        {{ $breadcrumbs }}
    </div>
</div>
<!-- Breadcrumb End -->
