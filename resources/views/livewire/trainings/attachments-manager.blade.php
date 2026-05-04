<div x-data="dropZone()" class="space-y-5">
    {{-- ===================== --}}
    {{-- 1. STREFA DRAG & DROP --}}
    {{-- ===================== --}}
	@unless($viewonly)
    <div
        x-on:dragover.prevent="dragging = true"
        x-on:dragleave.prevent="dragging = false"
        x-on:drop.prevent="onDrop($event)"
        :class="{
            'border-blue-500 bg-blue-50 scale-[1.005]': dragging,
            'border-gray-300 bg-gray-50 hover:border-blue-400 hover:bg-blue-50/40': !dragging
        }"
        class="relative border-2 border-dashed rounded-xl px-8 py-7 text-center
               transition-all duration-200 select-none"
    >
        {{-- Overlay TYLKO podczas uploadu tymczasowego --}}
        <div
            wire:loading
            wire:target="newFiles"
            class="absolute inset-0 flex flex-col items-center justify-center text-center
                   bg-white/85 rounded-xl backdrop-blur-sm z-10"
        >
            {{-- <svg class="w-7 h-7 animate-spin text-blue-500 mb-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg> --}}
            <p class="text-xs text-gray-500">
				<img src="{{ asset('img/loadhourglass.gif') }}" alt="Loading" class="size-16">
				{{ __('trainings.labels.uploading_files') }}
			</p>
        </div>

        <label class="flex items-center justify-center gap-4 cursor-pointer">
            <svg class="w-8 h-8 text-gray-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            <div class="text-left">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold text-blue-600">{{ __('trainings.labels.click_to_add_files') }}</span>
                    {{ __('trainings.labels.or_drag_and_drop_files') }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('trainings.labels.multiple_files_with_max_size', ['size' => 10]) }}</p>
            </div>
            <input
                x-ref="input"
                type="file"
                multiple
                wire:model="newFiles"
                class="hidden"
            />
        </label>
    </div>

    {{-- ============== --}}
    {{-- 3. PASEK AKCJI --}}
    {{-- ============== --}}
    {{-- Flash --}}

    <div class="grid grid-cols-5 items-center justify-between pb-3 border-b border-gray-100">
		<div class="col col-span-3">
			@if(session('attachments_success'))
				<div class="flex items-center gap-2 px-4 py-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm">
					<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
					</svg>
					{{ session('attachments_success') }}
				</div>
			@endif

			@error('newFiles.*')
				<div class="flex items-center gap-2 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
					<svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
					</svg>
					{{ $message }}
				</div>
			@enderror
		</div>
		<div class="col">
			<p class="text-xs text-gray-400">
				@if(count($toDelete) > 0)
					<p class="text-red-500 text-xs font-medium">{{ count($toDelete) }} plik(ów) do usunięcia</p>
				@endif
				{{-- @if(count($toDelete) > 0 && count($newFiles) > 0)
					<p class="mx-1">·</p>
				@endif --}}
				@if(count($newFiles) > 0)
					<p class="text-blue-600 text-xs font-medium">{{ count($newFiles) }} nowy(ch) do dodania</p>
				@endif
			</p>
		</div>
		<div class="col">

			<button
				type="button"
				wire:click="save"
				wire:loading.attr="disabled"
				wire:target="save"
				class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium
					rounded-lg hover:bg-blue-700 active:bg-blue-800
					disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-150"
			>
				<x-feather-upload wire:loading.remove wire:target="save" class="size-4" />
				<x-feather-refresh-cw wire:loading wire:target="save" class="size-4 animate-spin" />
				{{ __('trainings.actions.save_attachments') }}
			</button>
		</div>
    </div>
    @endunless

    {{-- ========================== --}}
    {{-- 2. DWA PANELE OBOK SIEBIE --}}
    {{-- ========================== --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

        {{-- ---- LEWY PANEL: już zapisane ---- --}}
        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    {{ __('trainings.labels.saved_attachments') }}
                </h4>
                <div class="flex items-center gap-2">
                    @if(count($toDelete) > 0)
                        <span class="text-xs text-red-500 font-medium">
                            {{ count($toDelete) }} {{ __('trainings.labels.to_be_deleted') }}
                        </span>
                    @endif
                    <span class="px-2 py-0.5 bg-gray-200 text-gray-600 rounded-full text-xs font-medium">
                        {{ count($existingAttachments) }}
                    </span>
                </div>
            </div>

            @if(count($existingAttachments) === 0)
                <div class="flex flex-col items-center justify-center py-12 text-center px-4">
                    <svg class="w-8 h-8 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-xs text-gray-400">{{ __('trainings.labels.no_saved_attachments') }}</p>
                </div>
            @else
                <ul class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                    @foreach($existingAttachments as $attachment)
                        @php $markedDelete = in_array($attachment['id'], $toDelete); @endphp
                        <li class="flex items-start gap-3 px-4 py-3 transition-colors duration-150
                            {{ $markedDelete ? 'bg-red-50/70 opacity-60' : 'hover:bg-gray-50' }}">

                            {{-- Ikona wg rozszerzenia --}}
                            @php
                                $ext = strtolower(pathinfo($attachment['original_name'] ?? '', PATHINFO_EXTENSION));
                                $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp','svg']);
                                $isPdf   = $ext === 'pdf';
                                $isSheet = in_array($ext, ['xls','xlsx','csv']);
                                $isDoc   = in_array($ext, ['doc','docx']);

								switch($ext) {
									case 'jpg':
									case 'jpeg':
									case 'png':
									case 'gif':
									case 'webp':
									case 'svg':
										$icon = '<x-feather-image class="shrink-0 size-4 text-purple-600" />';
										$iconBgColor = 'bg-purple-100';
										break;
									case 'pdf':
										$icon = '<x-feather-file class="shrink-0 size-4 text-red-600" />';
										$iconBgColor = 'bg-red-100';
										break;
									case 'xls':
									case 'xlsx':
									case 'csv':
										$icon = '<x-feather-file class="shrink-0 size-4 text-green-600" />';
										$iconBgColor = 'bg-green-100';
										break;
									case 'doc':
									case 'docx':
										$icon = '<x-feather-file class="shrink-0 size-4 text-blue-600" />';
										$iconBgColor = 'bg-blue-100';
										break;
									default:
										$icon = '<x-feather-file class="shrink-0 size-4 text-gray-600" />';
										$iconBgColor = 'bg-gray-100';
										break;
								}
                            @endphp
                            <div class="shrink-0 mt-0.5 w-8 h-8 rounded-lg flex items-center justify-center {{ $iconBgColor }}">
								<x-feather-file class="shrink-0 size-4 text-gray-600" />
                            </div>

                            {{-- Nazwa + rozmiar + notatka --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate"
                                   title="{{ $attachment['original_name'] ?? '' }}">
                                    {{ $attachment['original_name'] ?? '—' }}
                                </p>
                                <p class="text-xs text-gray-400 mb-1">
                                    {{ number_format(($attachment['size'] ?? 0) / 1024, 1) }} KB
                                </p>
                                <input
                                    type="text"
                                    wire:model.blur="existingNotes.{{ $attachment['id'] }}"
                                    placeholder="{{ __('trainings.th.attachment_note') }}"
                                    class="w-full text-xs bg-transparent border-0 border-b border-gray-200
                                           focus:border-blue-400 focus:ring-0 placeholder-gray-300 py-0.5
                                           transition-colors duration-150"
                                    {{ $markedDelete ? 'disabled' : '' }}
                                />
                            </div>

                            {{-- Akcje --}}
                            <div class="flex-shrink-0 flex items-center gap-0.5 mt-0.5">
                                @if(!$markedDelete)
                                    <a href="{{ route('trainings.attachment-download', [$attachment['training_id'], $attachment['uuid']]) }}"
                                       target="_blank"
                                       class="p-1.5 rounded text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                       title="{{ __('app.actions.download') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                    </a>
                                    <button
                                        type="button"
                                        wire:click="markDelete({{ $attachment['id'] }})"
                                        class="p-1.5 rounded text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                        title="{{ __('app.actions.mark-for-delete') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        wire:click="unmarkDelete({{ $attachment['id'] }})"
                                        class="px-2 py-1 text-xs rounded text-blue-600 bg-blue-50
                                               hover:bg-blue-100 transition-colors font-medium">
                                        {{ __('app.actions.undo') }}
                                    </button>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- ---- PRAWY PANEL: nowe do dodania ---- --}}
        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    {{ __('trainings.labels.new_to_be_added') }}
                </h4>
                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                    {{ count($newFiles) > 0 ? 'bg-blue-100 text-blue-600' : 'bg-gray-200 text-gray-500' }}">
                    {{ count($newFiles) }}
                </span>
            </div>

            @if(count($newFiles) === 0)
                <div class="flex flex-col items-center justify-center py-12 text-center px-4">
                    <svg class="w-8 h-8 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-xs text-gray-400">{{ __('trainings.labels.add_files_above') }}</p>
                </div>
            @else
                <ul class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                    @foreach($newFiles as $i => $file)
                        <li class="flex items-start gap-3 px-4 py-3 hover:bg-blue-50/30 transition-colors">
                            <div class="flex-shrink-0 mt-0.5 w-8 h-8 rounded-lg bg-blue-100
                                        flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                           a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate"
                                   title="{{ $file->getClientOriginalName() }}">
                                    {{ $file->getClientOriginalName() }}
                                </p>
                                <p class="text-xs text-gray-400 mb-1">
                                    {{ number_format($file->getSize() / 1024, 1) }} KB
                                </p>
                                <input
                                    type="text"
                                    wire:model.blur="newNotes.{{ $i }}"
                                    placeholder="{{ __('trainings.th.attachment_note') }}"
                                    class="w-full text-xs bg-transparent border-0 border-b border-blue-200
                                           focus:border-blue-400 focus:ring-0 placeholder-gray-300 py-0.5
                                           transition-colors duration-150"
                                />
                            </div>
                            <div class="flex-shrink-0 mt-0.5">
                                <button
                                    type="button"
                                    wire:click="removeNewFile({{ $i }})"
                                    class="p-1.5 rounded text-gray-400 hover:text-red-600
                                           hover:bg-red-50 transition-colors"
                                    title="Usuń z kolejki">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

</div>

@script
<script>
Alpine.data('dropZone', () => ({
    dragging: false,

    onDrop(event) {
        this.dragging = false;
        const files = event.dataTransfer?.files;
        if (!files?.length) return;

        const input = this.$refs.input;
        const dt = new DataTransfer();
        Array.from(files).forEach(f => dt.items.add(f));
        input.files = dt.files;
        input.dispatchEvent(new Event('change', { bubbles: true }));
    }
}));
</script>
@endscript
