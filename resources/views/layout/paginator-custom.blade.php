<div>
    <p class="text-sm text-gray-700 leading-5 dark:text-gray-600">
        {!! __('Showing') !!}
        @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            —
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
        @else
            {{ $paginator->count() }}
        @endif
        {!! __('of') !!}
        <span class="font-medium">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>
</div>
<div>
        <div class="inline-flex gap-x-2">
            <nav class="flex items-center gap-x-1" aria-label="Pagination">
                @if ( !$paginator->onFirstPage() )
                    <a href="{{ $paginator->url(1) }}" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous">
                        <x-feather-chevrons-left class="shrink-0 size-4" />
                    </a>
                    <a href="{{ $paginator->previousPageUrl() }}" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none" aria-label="Previous">
                        <x-feather-chevron-left class="shrink-0 size-4" />
                    </a>
                @endif

                @if ($paginator->lastPage() > 12)
                    <div class="flex items-center gap-x-1">
                        @if( $paginator->currentPage() > 4)
                            <a href="{{ $paginator->url(1) }}" aria-current="page" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none">
                                1
                            </a>
                            <a href="{{ $paginator->url(2) }}" aria-current="page" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none">
                                2
                            </a>
                            <a href="{{ $paginator->url(3) }}" aria-current="page" class="min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none">
                                3
                            </a>
                            <button type="button" class="hs-tooltip-toggle group min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-400 dark:text-neutral-500 hover:text-gray-900 dark:hover:text-neutral-300 p-2 text-sm rounded-lg focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                                <span class="group-hover:hidden text-xs">•••</span>
                                <svg class="group-hover:block hidden shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 17 5-5-5-5"/><path d="m13 17 5-5-5-5"/></svg>
                                <span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-gray-900 dark:bg-white border border-transparent text-xs font-medium text-white dark:text-neutral-800 rounded-md shadow-2xs" role="tooltip">
                                    Next 4 pages
                                </span>
                            </button>
                        @else
                            @for ($i = 1; $i <= min(3, $paginator->lastPage()); $i++)
                                <a href="{{ $paginator->url($i) }}"
                                class="{{ $i == $paginator->currentPage() ? 'bg-blue-600 text-white' : 'bg-white' }} px-3 py-2 rounded">
                                    {{ $i }}
                                </a>
                            @endfor
                        @endif

                        {{-- @foreach ($elements as $element)
                            @if (is_string($element))
                                <span aria-disabled="true">
                                    <span class="inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300">{{ $element }}</span>
                                </span>
                            @endif

                            @if (is_string($element))
                                <span class="px-3 py-2 bg-gray-200">{{ $element }}</span>
                            @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    <a href="{{ $url }}" aria-current="page" @class([
                                        "min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 py-2 px-3 text-sm rounded-lg focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none",
                                        'bg-gray-200 text-neutral-600' => $page == $paginator->currentPage(),
                                    ])>
                                        {{ $page }}
                                    </a>
                                @endforeach
                            @endif
                        @endforeach --}}
                    </div>
                @else
                @endif

                @if ( $paginator->hasMorePages() )
                    <a href="{{ $paginator->nextPageUrl() }}" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none" aria-label="Next">
                        <x-feather-chevron-right class="shrink-0 size-4" />
                    </a>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="min-h-9.5 min-w-9.5 py-2 px-2.5 inline-flex justify-center items-center gap-x-1.5 text-sm rounded-lg text-gray-800 dark:text-neutral-200 hover:bg-gray-100 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-100 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none" aria-label="Next">
                        <x-feather-chevrons-right class="shrink-0 size-4" />
                    </a>
                @endif
            </nav>
        </div>
</div>
