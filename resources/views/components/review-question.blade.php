@props([
    'name'  => Str::random(8),
    'class' => 'flex flex-wrap items-center py-4 hover:bg-gray-100 dark:hover:bg-gray-700',
])

<div {{ $attributes->merge(['class' => $class]) }}>
    <div class="w-full flex space-between px-1 md:w-1/2">
        {{ $slot }}
    </div>
    <div class="w-full px-auto md:w-1/12 font-bold text-right text-red-800">
        @error('review.'. $name)
            @svg('heroicon-s-arrow-right', 'w-6 h-6')
        @enderror
    </div>
    <div class="w-full px-1 md:w-1/12 text-center cursor-pointer">
			<input type="radio" value="1" name="review[{{ $name }}]" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
				@checked(old('review.'. $name) == 1)>
    </div>
    <div class="w-full px-1 md:w-1/12 text-center">
            <input type="radio" value="2" name="review[{{ $name }}]" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
               @checked(old('review.'. $name) == 2)
            >
    </div>
    <div class="w-full px-1 md:w-1/12 text-center">
            <input type="radio" value="3" name="review[{{ $name }}]" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
                @checked(old('review.'. $name) == 3)
            >
    </div>
    <div class="w-full px-1 md:w-1/12 text-center">
            <input type="radio" value="4" name="review[{{ $name }}]" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
                @checked(old('review.'. $name) == 4)
            >
    </div>
    <div class="w-full px-1 md:w-1/12 text-center">
            <input type="radio" value="5" name="review[{{ $name }}]" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
                @checked(old('review.'. $name) == 5)
            >
    </div>
</div>
