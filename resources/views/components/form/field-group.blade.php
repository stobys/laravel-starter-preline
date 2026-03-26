@blaze

@props([
    'id' => Str::random(10),
    'label' => 'Label',
    'name' => null,
    'helper' => null,
    'hint' => null,
])

<div>
    <div class="mb-2 flex flex-wrap justify-between items-center gap-2">
        <label for="{{ $id }}" class="block text-sm font-medium text-foreground">{{ $label }}</label>
        @if($hint)
            <span class="block text-sm text-muted-foreground-1">{{ $hint }}</span>
        @endif
    </div>
    <div class="relative">
        {{ $slot }}
        @if( $errors->has($name) )
            <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                <x-feather-alert-circle class="shrink-0 size-4 text-red-500" />
            </div>
        @endif
    </div>
    @if( $errors->has($name) )
        <p class="text-sm text-red-500 mt-2" id="{{ $name }}-error-helper">{{ $errors->first($name) }}</p>
    @else
        @if($helper)
            <p id="input-base-helper-text" class="mt-2 text-sm text-muted-foreground-1">{{ $helper }}</p>
        @endif
    @endif
</div>
