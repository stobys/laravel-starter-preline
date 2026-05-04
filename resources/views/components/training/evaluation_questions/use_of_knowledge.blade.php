@blaze()
@props([])

<div class="flex flex-wrap items-center py-4 hover:bg-gray-100" x-data="{ choice: '{{ old('evaluation_of_use_of_knowledge') }}' }">
    <div class="w-full px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge') }}
        @error('evaluation_of_use_of_knowledge')
            <p class="text-sm text-red-800">{{ $message }}</p>
        @enderror
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input x-model="choice" type="radio" value="1" name="evaluation_of_use_of_knowledge" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
                @checked(old('evaluation_of_use_of_knowledge') == '1')
            >
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
			<input x-model="choice" type="radio" value="0" name="evaluation_of_use_of_knowledge" class="shrink-0 size-6 cursor-pointer rounded-full shadow-2xs disabled:opacity-50 disabled:pointer-events-none
				bg-gray-100 dark:bg-gray-700 checked:bg-company-teal dark:checked:bg-company-green-2
				border-gray-300 dark:border-gray-600 checked:border-company-teal
				focus:ring-company-teal dark:focus:ring-company-green-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-700"
                @checked(old('evaluation_of_use_of_knowledge') == '0')
            >
    </div>

    <div x-show="choice === '1'" class="w-full mt-4 px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge_details_yes') }}
        @error('evaluation_of_use_of_knowledge_comment')
            <p class="text-sm text-red-800">{{ $message }}</p>
        @enderror
    </div>
    <div x-show="choice === '0'" class="w-full mt-4 px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge_details_no') }}
        @error('evaluation_of_use_of_knowledge_comment')
            <p class="text-sm text-red-800">{{ $message }}</p>
        @enderror
    </div>
    <div x-show="choice" class="w-full mt-4 px-1 md:w-1/3 text-center">
        <textarea id="evaluation_of_use_of_knowledge_comment" name="evaluation_of_use_of_knowledge_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
        >{{ old('evaluation_of_use_of_knowledge_comment') }}</textarea>
    </div>
</div>
