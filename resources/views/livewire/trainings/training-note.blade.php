<div>
	<!-- resources/views/livewire/training-note.blade.php -->

	{{-- Trigger otwierania drawera przez JS gdy Livewire załaduje dane --}}
    <div x-data x-on:open-training-note-drawer.window="$nextTick(() => document.getElementById('training-note-trigger').click())"></div>
	<span id="training-note-trigger" data-hs-overlay="#training-note-drawer" class="hidden"></span>

    {{-- Drawer --}}
    <div
        id="training-note-drawer"
        class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 start-0 transition-all duration-300 transform h-full max-w-2xl w-full z-80 bg-overlay border-s border-overlay-line"
        role="dialog"
        tabindex="-1"
    >
        <div class="flex flex-col h-full">

            {{-- Header --}}
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
				<h3 class="font-semibold text-gray-800">Notatka : {{ $trainingTitle ?? '' }}</h3>
                <button type="button" data-hs-overlay="#training-note-drawer"
                    class="text-gray-500 hover:text-gray-800"
                >
                    <x-feather-x class="shrink-0 size-4"/>
                </button>
            </div>

            {{-- Ciało --}}
            <div class="flex-1 overflow-y-auto p-4">
                @if($trainingId)
                    <textarea wire:model="note" rows="10" placeholder="Wpisz notatkę..."
                        class="w-full border border-gray-200 rounded-lg p-3 text-sm focus:outline-none focus:ring-1 focus:ring-company-teal"
                    ></textarea>
                @endif
            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 px-4 py-3 border-t border-gray-200">
                <button type="button" data-hs-overlay="#training-note-drawer"
                    class="py-2 px-3 text-sm rounded-lg border border-gray-200 hover:bg-gray-50 inline-flex items-center gap-x-2"
                >
					<x-feather-x class="shrink-0 size-4" />
                    {{ __('app.actions.close') }}
                </button>
                <button type="button" wire:click="save"
                    class="py-2 px-3 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
					<span wire:loading.remove wire:target="save">
						<span class="inline-flex items-center gap-x-2">
							<x-feather-save class="shrink-0 size-4" />
							{{ __('app.actions.save') }}
						</span>
					</span>
    				<span wire:loading wire:target="save">
						<span class="inline-flex items-center gap-x-2">
							<x-feather-refresh-cw class="animate-spin shrink-0 size-4"  />
							{{ __('app.actions.saving') }}
						</span>
					</span>
                </button>
            </div>

        </div>
    </div>
</div>

