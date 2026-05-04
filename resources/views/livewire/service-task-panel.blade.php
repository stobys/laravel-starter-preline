<div class="flex border border-gray-200 rounded-xl overflow-hidden min-h-[520px]">

  	{{-- Sidebar z listą tasków --}}
	<div class="w-64 flex-shrink-0 border-r border-gray-200 flex flex-col">
		<div class="px-4 py-3 border-b border-gray-200">
			<p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Dostępne zadania</p>
		</div>
		<div class="flex-1 overflow-y-auto p-2">
			@foreach($tasks as $class => $task)
			<button wire:click="selectTask('{{ $class }}')"
				class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-left transition-colors
				{{ $selectedTask === $class ? 'bg-gray-100 font-medium' : 'hover:bg-gray-50' }}"
			>
				<span class="text-sm text-gray-700 truncate">{{ $task->name() }}</span>
			</button>
			@endforeach
		</div>
	</div>

	{{-- Panel szczegółów --}}
	<div class="flex-1 flex flex-col">

		@if(!$selectedTask)
			<div class="flex-1 flex items-center justify-center text-gray-400 text-sm">
				Wybierz zadanie z listy
			</div>
		@else
			@php
				$task = $tasks[$selectedTask];
			@endphp

			{{-- Header --}}
			<div class="flex items-center justify-between gap-4 px-6 py-5 border-b border-gray-200">
				<div class="flex-1">
					<p class="font-medium text-gray-900">{{ $task->name() }}</p>
					<p class="text-sm text-gray-500 mt-1">{{ $task->description() }}</p>
				</div>

				@if($tasks[$selectedTask]->supportsDryRun())
				<label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
					<input type="checkbox" class="rounded border-gray-300"
						wire:model.live="dryRunMode"
					/>
					Dry-run
				</label>
				@endif

				<button type="button" wire:click="runTask" wire:loading.attr="disabled"
					class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-hover disabled:opacity-50 disabled:pointer-events-none"
				>
					<span wire:loading.remove wire:target="runTask">
						{{ $dryRunMode ? 'Symuluj' : 'Uruchom' }}
					</span>
					<x-feather-arrow-right wire:loading.remove wire:target="runTask" class="shrink-0 size-4" />

					<span wire:loading wire:target="runTask">
						{{ $dryRunMode ? 'Symulowanie ...' : 'Uruchamianie ...' }}
					</span>
					<x-feather-refresh-cw wire:loading wire:target="runTask" class="animate-spin shrink-0 size-4" />
				</button>
			</div>

			{{-- Parametry --}}
			<div class="flex-1 px-6 py-5">
				@if(empty($task->parameters()))
					<p class="text-sm text-gray-400">To zadanie nie wymaga żadnych parametrów.</p>
				@else
					<div class="grid grid-cols-5 gap-4">
						@foreach($task->parameters() as $param)
							{{-- <x-form.field-group :for="$param['name']" :label="$param['label']" name="params.{{ $param['name'] }}" helper="helper" hint="hint"
								:placeholder="{{ $param['label'] }}" :required="$param['required']"
							>
								<x-form.input :type="$param['type']" :name="$param['name']" :placeholder="$param['label']" :required="$param['required']" />
							</x-form.field-group> --}}

							<div class="flex flex-col gap-1.5">
								<label class="text-xs font-medium text-gray-500">
									{{ $param->label }}
									@if($param->required)
									<span class="text-red-400">*</span>
									@endif
								</label>

								@switch($param->type)
									@case('checkbox')
										<div class="flex items-center">
											<input type="checkbox" wire:model="fields.{{ $param->name }}" value="{{ $param->value }}" class="shrink-0 size-6 bg-transparent border-line-3 rounded-sm shadow-2xs text-primary focus:ring-0 focus:ring-offset-0 checked:bg-primary-checked checked:border-primary-checked disabled:opacity-50 disabled:pointer-events-none"
												@checked($param->checked ?? false)
											>
										</div>
									@break

									@default
										<input
											type="{{ $param->type }}"
											wire:model="fields.{{ $param->name }}"
											placeholder="{{ $param->label }}"
											class="hs-input w-full text-sm"
										/>
								@endswitch

								@error($param->name)
									<p class="text-xs text-red-500">{{ $message }}</p>
								@enderror
							</div>
						@endforeach
					</div>
				@endif
			</div>

			{{-- Footer z wynikiem i przyciskiem --}}
			<div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between gap-4">

				{{-- Wynik --}}
				<div class="flex-1 text-sm">
					@if($result)
						<span @class(['flex items-center gap-1.5',
										'text-green-600' => $result['success'],
										'text-red-500' => !$result['success'],
						])>
							@if($result['success'])
								<x-feather-check class="size-4" />
							@else
								<x-feather-x class="size-4" />
							@endif

							{{ $result['message'] }}
						</span>
					@endif
				</div>

				{{-- @if($tasks[$selectedTask]->supportsDryRun())
				<label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer select-none">
					<input type="checkbox" class="rounded border-gray-300"
						wire:model.live="dryRunMode"
					/>
					Dry-run
				</label>
				@endif

				<button type="button" wire:click="runTask" wire:loading.attr="disabled"
					class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-layer border border-layer-line text-layer-foreground shadow-2xs hover:bg-layer-hover focus:outline-hidden focus:bg-layer-hover disabled:opacity-50 disabled:pointer-events-none"
				>
					<span wire:loading.remove wire:target="runTask">
						{{ $dryRunMode ? 'Symuluj' : 'Uruchom' }}
					</span>
					<x-feather-arrow-right wire:loading.remove wire:target="runTask" class="shrink-0 size-4" />

					<span wire:loading wire:target="runTask">
						{{ $dryRunMode ? 'Symulowanie ...' : 'Uruchamianie ...' }}
					</span>
					<x-feather-refresh-cw wire:loading wire:target="runTask" class="animate-spin shrink-0 size-4" />
				</button> --}}

			</div>
		@endif

	</div>
</div>
