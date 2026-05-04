@blaze()
@props([
    'name'  => Str::random(8),
    'class' => 'flex flex-wrap items-center py-4 hover:bg-gray-100',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="w-full flex space-between px-1 md:w-1/2">
        {{ $slot }}
    </div>
    <div class="w-full px-auto md:w-1/6 font-bold text-right text-red-800">
        @error('eval.'. $name)
            @svg('heroicon-s-arrow-right', 'w-6 h-6')
        @enderror
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input type="radio" value="1" name="eval[{{ $name }}]" class="w-5 h-5 cursor-pointer text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                @checked(old('eval.'. $name) == 1)
            >
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input type="radio" value="2" name="eval[{{ $name }}]" class="w-5 h-5 cursor-pointer text-red-300 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
               @checked(old('eval.'. $name) == 2)
            >
    </div>
    <div class="w-full mt-4 flex space-between px-1 md:w-4/6"></div>
    <div class="w-full mt-4 px-1 md:w-2/6 text-center">
        <textarea id="evaluation_comment" name="evaluation_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
        >{{ old('evaluation_comment') }}</textarea>
    </div>

</div>


        {{-- <div class="grid grid-cols-[6fr_1fr_5fr] gap-1">
            <div class="p-5">
                {{ $slot }}
            </div>
            <div class="p-5">
                @error('effect.'. $name)
                    @svg('heroicon-s-arrow-right', 'w-6 h-6')
                @enderror
            </div>
            <div class="grid grid-cols-2 grid-rows-2 gap-1">
                <div class="bg-blue-500 p-5 text-white ">Cell 1</div>
                <div class="bg-orange-500 p-5 text-white ">Cell 2</div>
                <div class="p-5  text-lg col-span-2">
                    <textarea id="evaluation_comment" name="evaluation_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
                    >{{ old('evaluation_comment') }}</textarea>
                </div>
            </div>
        </div> --}}
