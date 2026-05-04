@blaze()

@props([
    'id' 		=> str()->random(5),
	'title'		=> 'Title',

	'footer'	=> null,
])

<div id="{{ $id }}" @class([
	"hs-overlay hs-overlay-backdrop-open:bg-black/75 hidden size-full fixed top-0 start-0 z-999 overflow-x-hidden overflow-y-auto pointer-events-none",
	"[--overlay-backdrop:static]" => false
]) role="dialog" tabindex="-1" aria-labelledby="{{ $id }}-modal-label"
>
	<div class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500 mt-14 opacity-0 ease-out transition-all sm:max-w-lg sm:w-full md:max-w-2xl md:w-full m-3 sm:mx-auto">
		<div class="flex flex-col bg-white dark:bg-neutral-800 border border-transparent shadow-2xs rounded-xl pointer-events-auto">
			<div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-700">
				<h3 id="{{ $id }}-modal-label" class="font-semibold text-gray-800 dark:text-neutral-200">
					{{ $title }}
				</h3>
				<button  data-hs-overlay="#{{ $id }}" type="button" class="hs-dropup-toggle size-8 inline-flex justify-center items-center gap-x-2 rounded-full bg-gray-100 dark:bg-neutral-700 border border-transparent text-gray-800 dark:text-neutral-200 hover:bg-gray-200 dark:hover:bg-neutral-600 focus:outline-hidden focus:bg-gray-200 dark:focus:bg-neutral-600 disabled:opacity-50 disabled:pointer-events-none" aria-label="Close">
					<span class="sr-only">Close</span>
					<x-feather-x class="shrink-0 size-4" />
				</button>
			</div>
			<div class="p-4 overflow-y-auto">{{ $slot }}</div>
			<div class="flex justify-end items-center gap-x-2 py-3 px-4 border-t border-gray-200 dark:border-neutral-700">
				@if($footer)
					{{ $footer }}
				@else
					<button data-hs-overlay="#{{ $id }}" type="button" class="hs-dropup-toggle py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-white dark:bg-neutral-800 border border-gray-200 dark:border-neutral-700 text-gray-800 dark:text-white shadow-2xs hover:bg-gray-50 dark:hover:bg-neutral-700 focus:outline-hidden focus:bg-gray-50 dark:focus:bg-neutral-700 disabled:opacity-50 disabled:pointer-events-none">
						Close
					</button>
					<button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-gray-800 dark:bg-white border border-transparent text-white dark:text-neutral-800 hover:bg-gray-900 dark:hover:bg-neutral-300 focus:outline-hidden focus:bg-gray-900 dark:focus:bg-neutral-300 disabled:opacity-50 disabled:pointer-events-none">
						Save changes
					</button>
				@endif
			</div>
		</div>
	</div>
</div>
