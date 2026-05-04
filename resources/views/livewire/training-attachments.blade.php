<div>

    <div class="grid grid-cols-4 gap-4">
        @forelse($this->fetchTraining()->attachments as $attachment)
            <x-training.attachment :file="$attachment" />
        @empty
            <p class="text-sm text-gray-500">No attachments yet.</p>
        @endforelse
    </div>

    <div class="inline-flex items-center justify-center w-full">
        <hr class="w-full h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
        <span class="absolute px-3 font-medium text-gray-900 -translate-x-1/2 bg-white left-1/2 dark:text-white dark:bg-gray-900">upload more files below</span>
    </div>

    {{-- <div class="flex items-center justify-center w-full">
        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                </svg>
                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <input id="dropzone-file" type="file" class="hidden" />
        </label>
    </div> --}}


    <form wire:submit="save" class="space-y-6">
        <div
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false; progress = 0"
            x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="uploading = false; progress = $event.detail.progress"
            class="space-y-3"
        >

            {{-- <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="attachments">Upload multiple files</label> --}}
            <input class="block w-full mb-5 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="default_size" type="file" wire:model="attachments" multiple />

            <div wire:loading wire:target="attachments" class="text-sm text-gray-500">
                Przesyłanie…
            </div>


            <div x-show="uploading" class="space-y-1">
                <div class="h-2 bg-gray-200 rounded">
                    <div class="h-2 bg-blue-600 rounded" :style="`width:${progress}%;`"></div>
                </div>
                <div class="text-sm text-gray-600" x-text="progress + '%'"></div>
            </div>

            @error('attachments.*')
                <div class="text-sm text-red-600">{{ $message }}</div>
            @enderror
        </div>

        @if($attachments && count($attachments))
        <div class="overflow-x-auto">
            <table class="min-w-full border divide-y">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-2 text-left">Podgląd / Ikona</th>
                        <th class="p-2 text-left">Nazwa</th>
                        <th class="p-2 text-left">MIME</th>
                        <th class="p-2 text-left">Rozmiar</th>
                        <th class="p-2 text-left">Akcje</th>
                    </tr>
                </thead>
                <tfoot class="bg-gray-50 border">
                    <tr>
                        <td colspan="5" class="p-2 text-center">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">
                                Załącz
                            </button>
                        </td>
                    </tr>
                </tfoot>
                <tbody class="divide-y">
                    @foreach($attachments as $idx => $file)
                        @php
                            $uploaded = method_exists($file, 'getFilename') ? $file->getFilename() : null;
                            $isImage = str_starts_with($file->getMimeType(), 'image/');
                        @endphp
                    <tr>
                        <td class="p-2 align-top">
                            @if($isImage)
                                <img src="{{ $file->temporaryUrl() }}" alt="preview" class="h-12 w-12 object-cover rounded border" />
                            @else
                                <div class="h-12 w-12 flex items-center justify-center rounded border bg-gray-100">
                                    <span class="text-xs font-medium">
                                        {{ strtoupper(explode('/', $file->getMimeType())[1] ?? 'FILE') }}
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td class="p-2 align-top">
                            {{ $file->getClientOriginalName() }}
                        </td>
                        <td class="p-2 align-top">
                            {{ $file->getMimeType() }}
                        </td>
                        <td class="p-2 align-top">
                            {{ Number::fileSize($file->getSize(), precision: 2) }}
                        </td>
                        <td class="p-2 align-top">
                            <button type="button" class="px-2 py-1 text-red-700 hover:underline"
                                wire:click="removeItem({{ $idx }})">
                                    Usuń
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif

    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('confirm-delete', e => {
                const uuid = e.detail.uuid;

                Swal.fire({
                    title: 'Na pewno usunąć załącznik?',
                    text: 'Operacji nie można cofnąć',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Tak, usuń',
                    cancelButtonText: 'Anuluj',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // console.log(uuid +' - confirmed');
                        // Livewire v3: wywołanie metody komponentu
                        // Livewire.find(e.target.closest('[wire\\:id]').getAttribute('wire:id')).call('deleteAttachment', uuid);

                        // Ewentualnie, będąc wewnątrz tego samego komponentu:
                        @this.call('deleteAttachment', uuid)
                    }
                });
            });
        });
    </script>
@endpush
