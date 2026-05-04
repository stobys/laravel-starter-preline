@blaze()
@props([
    'eval' => null
])

<div class="flex flex-wrap items-center py-4 hover:bg-gray-100">
    <div class="w-full px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge') }}
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input disabled type="radio" value="1" name="evaluation_of_use_of_knowledge" class="w-5 h-5 cursor-pointer text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                @checked($eval->evaluation_of_use_of_knowledge == '1')
            >
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input disabled type="radio" value="0" name="evaluation_of_use_of_knowledge" class="w-5 h-5 cursor-pointer text-red-300 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            @checked($eval->evaluation_of_use_of_knowledge == '0')
            >
    </div>

    @if($eval->evaluation_of_use_of_knowledge == '1')
    <div class="w-full mt-4 px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge_details_yes') }}
    </div>
    @endif

    @if($eval->evaluation_of_use_of_knowledge == '0')
    <div class="w-full mt-4 px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_use_of_knowledge_details_no') }}
    </div>
    @endif

    <div x-show="choice" class="w-full mt-4 px-1 md:w-1/3 text-center">
        <textarea readonly disabled id="evaluation_of_use_of_knowledge_comment" name="evaluation_of_use_of_knowledge_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
        >{{ $eval->evaluation_of_use_of_knowledge_comment }}</textarea>
    </div>
</div>
