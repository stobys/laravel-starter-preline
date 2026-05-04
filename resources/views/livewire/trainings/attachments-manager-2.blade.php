{{-- resources/views/livewire/attachments-manager.blade.php --}}
<div x-data="attachmentsManager()" x-init="init()">

    {{-- === ISTNIEJĄCE ZAŁĄCZNIKI === --}}
    @if(count($existingAttachments) > 0)
    <div class="mb-6">
        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3">
            Istniejące załączniki
        </h4>
        <ul class="space-y-2">
            @foreach($existingAttachments as $attachment)
            <li class="flex items-center gap-3 p-3 rounded-lg border
                {{ in_array($attachment['id'], $attachmentsToDelete)
                    ? 'border-red-200 bg-red-50 opacity-60'
                    : 'border-gray-200 bg-gray-50' }}">

                {{-- Ikona typu pliku --}}
                <div class="flex-shrink-0 text-gray-400">
					<x-feather-file />
                    {{-- <x-file-icon :extension="pathinfo($attachment['original_name'], PATHINFO_EXTENSION)" /> --}}
                </div>

                {{-- Nazwa + notatka --}}
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">
                        {{ $attachment['original_name'] }}
                    </p>
                    <input
                        type="text"
                        wire:model="existingNotes.{{ $attachment['id'] }}"
                        placeholder="Dodaj notatkę..."
                        class="mt-1 w-full text-xs border-0 border-b border-gray-300 bg-transparent
                               focus:border-blue-500 focus:ring-0 placeholder-gray-400 py-0.5"
                        {{ in_array($attachment['id'], $attachmentsToDelete) ? 'disabled' : '' }}
                    />
                </div>

                {{-- Rozmiar --}}
                <span class="text-xs text-gray-400 flex-shrink-0">
                    {{ number_format($attachment['size'] / 1024, 1) }} KB
                </span>

                {{-- Akcje --}}
                @if(in_array($attachment['id'], $attachmentsToDelete))
                    <button type="button"
                        wire:click="unmarkForDeletion({{ $attachment['id'] }})"
                        class="text-xs text-blue-600 hover:text-blue-800 flex-shrink-0">
                        Przywróć
                    </button>
                @else
                    <a href="{{ Storage::url($attachment['path']) }}" target="_blank"
                        class="text-xs text-gray-500 hover:text-gray-700 flex-shrink-0">
                        Pobierz
                    </a>
                    <button type="button"
                        wire:click="markForDeletion({{ $attachment['id'] }})"
                        class="text-red-400 hover:text-red-600 flex-shrink-0"
                        title="Oznacz do usunięcia">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- === NOWE PLIKI (do dodania) === --}}
    @if(count($newFiles) > 0)
    <div class="mb-6">
        <h4 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3">
            Nowe pliki do dodania
        </h4>
        <ul class="space-y-2">
            @foreach($newFiles as $index => $file)
            <li class="flex items-center gap-3 p-3 rounded-lg border border-blue-200 bg-blue-50">
                <div class="flex-shrink-0 text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">
                        {{ $file->getClientOriginalName() }}
                    </p>
                    <input
                        type="text"
                        wire:model="newFilesNotes.{{ $index }}"
                        placeholder="Dodaj notatkę do pliku..."
                        class="mt-1 w-full text-xs border-0 border-b border-blue-300 bg-transparent
                               focus:border-blue-500 focus:ring-0 placeholder-gray-400 py-0.5"
                    />
                </div>
                <span class="text-xs text-gray-400 flex-shrink-0">
                    {{ number_format($file->getSize() / 1024, 1) }} KB
                </span>
                <button type="button"
                    wire:click="removeNewFile({{ $index }})"
                    class="text-red-400 hover:text-red-600 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- === STREFA UPLOADU === --}}
    <div
        x-on:dragover.prevent="dragging = true"
        x-on:dragleave.prevent="dragging = false"
        x-on:drop.prevent="handleDrop($event)"
        :class="dragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300 bg-gray-50'"
        class="border-2 border-dashed rounded-xl p-8 text-center transition-all duration-200 cursor-pointer"
        x-on:click="$refs.fileInput.click()"
    >
        <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
        </svg>
        <p class="text-sm text-gray-600">
            <span class="font-semibold text-blue-600">Kliknij, aby dodać pliki</span>
            lub przeciągnij i upuść
        </p>
        <p class="text-xs text-gray-400 mt-1">Wiele plików jednocześnie, max 10 MB każdy</p>

        <input
            x-ref="fileInput"
            type="file"
            multiple
            wire:model="newFiles"
            class="hidden"
            x-on:change="trackProgress($event)"
        />
    </div>

    {{-- === PASEK POSTĘPU === --}}
    <div wire:loading wire:target="newFiles" class="mt-4">
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
            <svg class="w-4 h-4 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            Przesyłanie plików...
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
            <div
                class="bg-blue-500 h-2 rounded-full transition-all duration-300"
                x-bind:style="`width: ${uploadPercent}%`"
            ></div>
        </div>
        <p class="text-xs text-gray-400 mt-1" x-text="`${uploadPercent}%`"></p>
    </div>

    {{-- Komunikaty błędów walidacji --}}
    @error('newFiles.*')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror

    {{-- Licznik podsumowania --}}
    <div class="mt-4 flex items-center gap-4 text-xs text-gray-500">
        <span>
            Istniejące:
            <strong>{{ count($existingAttachments) - count($attachmentsToDelete) }}</strong>
        </span>
        <span>Nowe do dodania: <strong>{{ count($newFiles) }}</strong></span>
        @if(count($attachmentsToDelete) > 0)
            <span class="text-red-500">Do usunięcia: <strong>{{ count($attachmentsToDelete) }}</strong></span>
        @endif
    </div>
</div>

@script
<script>
    Alpine.data('attachmentsManager', () => ({
        dragging: false,
        uploadPercent: 0,

        init() {
            // Nasłuchuje na postęp uploadu Livewire
            Livewire.on('upload:progress', (event) => {
                this.uploadPercent = event.progress;
            });
        },

        handleDrop(event) {
            this.dragging = false;
            const dataTransfer = event.dataTransfer;
            const input = this.$refs.fileInput;
            input.files = dataTransfer.files;
            input.dispatchEvent(new Event('change'));
        },

        trackProgress(event) {
            this.uploadPercent = 0;
        }
    }));
</script>
@endscript
