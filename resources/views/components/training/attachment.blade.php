@props([
    'file' => null,
])

<div class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50">
    <div class="flex items-center justify-center w-10 h-10 mr-3 rounded-lg bg-primary-100 dark:bg-primary-900">
        @if( $file->fileType() == 'image')
            @svg('feather-image', 'w-6 h-6 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300')
        @elseif( $file->fileType() == 'pdf')
            <svg class="w-6 h-6 text-primary-600 lg:w-6 lg:h-6 dark:text-primary-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M128 64C92.7 64 64 92.7 64 128L64 512C64 547.3 92.7 576 128 576L208 576L208 464C208 428.7 236.7 400 272 400L448 400L448 234.5C448 217.5 441.3 201.2 429.3 189.2L322.7 82.7C310.7 70.7 294.5 64 277.5 64L128 64zM389.5 240L296 240C282.7 240 272 229.3 272 216L272 122.5L389.5 240zM272 444C261 444 252 453 252 464L252 592C252 603 261 612 272 612C283 612 292 603 292 592L292 564L304 564C337.1 564 364 537.1 364 504C364 470.9 337.1 444 304 444L272 444zM304 524L292 524L292 484L304 484C315 484 324 493 324 504C324 515 315 524 304 524zM400 444C389 444 380 453 380 464L380 592C380 603 389 612 400 612L432 612C460.7 612 484 588.7 484 560L484 496C484 467.3 460.7 444 432 444L400 444zM420 572L420 484L432 484C438.6 484 444 489.4 444 496L444 560C444 566.6 438.6 572 432 572L420 572zM508 464L508 592C508 603 517 612 528 612C539 612 548 603 548 592L548 548L576 548C587 548 596 539 596 528C596 517 587 508 576 508L548 508L548 484L576 484C587 484 596 475 596 464C596 453 587 444 576 444L528 444C517 444 508 453 508 464z"/></svg>
        @else
            <svg class="w-6 h-6 text-primary-600 dark:text-primary-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path clip-rule="evenodd" fill-rule="evenodd" d="M5.625 1.5c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0016.5 9h-1.875a1.875 1.875 0 01-1.875-1.875V5.25A3.75 3.75 0 009 1.5H5.625zM7.5 15a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5A.75.75 0 017.5 15zm.75 2.25a.75.75 0 000 1.5H12a.75.75 0 000-1.5H8.25z"></path>
                <path d="M12.971 1.816A5.23 5.23 0 0114.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 013.434 1.279 9.768 9.768 0 00-6.963-6.963z"></path>
            </svg>
        @endif
    </div>
    <div class="mr-4">
        <p class="text-sm font-semibold text-gray-900 dark:text-white">
            {{ $file?->filename }}
        </p>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            <span class="uppercase">{{ $file->extentionFromName() }}</span>
            , {{ Number::fileSize($file?->size_bytes, precision: 2) }}
        </p>
    </div>
    <div class="flex items-center ml-auto">
        <a href="{{ route('trainings.attachment-download', [$file->training, $file]) }}" type="button" class="p-2 rounded hover:bg-gray-100">
            @svg('feather-download', 'w-5 h-5 text-gray-500 dark:text-gray-400')
            <span class="sr-only">Download</span>
        </a>
        <button wire:click="$dispatch('confirm-delete', { uuid: '{{ $file->uuid }}' })" type="button" class="p-2 rounded hover:bg-gray-100">
            @svg('feather-trash-2', 'w-5 h-5 text-gray-500 dark:text-gray-400')
            <span class="sr-only">Delete</span>
        </button>
    </div>
</div>
