{{-- Strefa drag & drop --}}
<div>
<div
    x-data="dropZone()"
    x-on:dragover.prevent="dragging = true"
    x-on:dragleave.prevent="dragging = false"
    x-on:drop.prevent="handleDrop($event)"
    :class="dragging
        ? 'border-blue-500 bg-blue-50 scale-[1.01]'
        : 'border-gray-300 bg-gray-50 hover:border-gray-400'"
    class="border-2 border-dashed rounded-xl p-8 text-center transition-all duration-200 cursor-pointer"
    x-on:click="$refs.fileInput.click()"
>
    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
    </svg>
    <p class="text-sm text-gray-600">
        <span class="font-semibold text-blue-600">Kliknij</span> lub przeciągnij pliki tutaj
    </p>
    <p class="text-xs text-gray-400 mt-1">Wiele plików jednocześnie, max 10 MB każdy</p>

    <input
        x-ref="fileInput"
        type="file"
        multiple
        class="hidden"
        x-on:change="handleFiles($event.target.files)"
    />
</div>

{{-- Pasek postępu --}}
<div x-data x-show="$wire.isUploading" class="mt-4">
    <div class="flex items-center gap-2 text-sm text-gray-600 mb-1">
        <svg class="w-4 h-4 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
        </svg>
        Przesyłanie...
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
        <div class="bg-blue-500 h-2 rounded-full transition-all duration-300"
            x-bind:style="`width: ${$wire.totalProgress}%`"></div>
    </div>
</div>

@script
<script>
Alpine.data('dropZone', () => ({
    dragging: false,

    handleDrop(event) {
        this.dragging = false;
        const files = event.dataTransfer.files;
        if (files.length) {
            this.handleFiles(files);
        }
    },

    handleFiles(files) {
        // Livewire upload API — jedyna metoda która działa z drag & drop
        Array.from(files).forEach(file => {
            $wire.upload(
                'newFiles',   // nazwa właściwości Livewire
                file,
                // success callback
                (uploadedFilename) => {
                    console.log('Uploaded:', uploadedFilename);
                },
                // error callback
                () => {
                    console.error('Upload failed for:', file.name);
                },
                // progress callback
                (event) => {
                    $wire.set('uploadProgress', event.detail.progress);
                }
            );
        });
    }
}));
</script>
@endscript
</div>
