    @if( $paginator->hasPages() )
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
                    <div class="flex items-center gap-x-1">
                        @foreach ($elements as $element)
                            @if (is_string($element))
                                <button href="{{ $paginator->url($paginator->currentPage()+4) }}" class="group min-h-9.5 min-w-9.5 flex justify-center items-center text-gray-400 dark:text-neutral-500 hover:text-gray-900 dark:hover:text-neutral-300 p-2 text-sm rounded-lg focus:outline-hidden focus:text-gray-900 dark:focus:text-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
                                    <span class="group-hover:hidden2 text-xs">•••</span>
                                    {{-- <x-feather-chevrons-left class="group-hover:block hidden shrink-0 size-5" /> --}}
                                </button>
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
                        @endforeach
                    </div>
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
    @endif
