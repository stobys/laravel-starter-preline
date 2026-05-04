@blaze()
@props([
    'eval' => null
])

<div class="flex flex-wrap items-center py-4 hover:bg-gray-100">
    <div class="w-full px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_need_for_further_training') }}
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input disabled type="radio" value="1" name="evaluation_of_need_for_further_training" class="w-5 h-5 cursor-pointer text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                @checked($eval->evaluation_of_need_for_further_training == '1')
            >
    </div>
    <div class="w-full px-1 md:w-1/6 text-center">
            <input disabled type="radio" value="0" name="evaluation_of_need_for_further_training" class="w-5 h-5 cursor-pointer text-red-300 bg-gray-100 border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            @checked($eval->evaluation_of_need_for_further_training == '2')
            >
    </div>
    @if($eval->evaluation_of_need_for_further_training == '1')
    <div class="w-full mt-4 px-1 md:w-2/3">
        {{ __('trainings.evaluations.evaluation_of_need_for_further_training_details_yes') }}
    </div>
    <div class="w-full mt-4 px-1 md:w-1/3 text-center">
        <textarea readonly disabled id="evaluation_comment" name="evaluation_of_need_for_further_training_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
        >{{ $eval->evaluation_of_need_for_further_training_comment }}</textarea>
    </div>
    @endif

    {{-- <div x-show="choice === '0'" class="w-full mt-4 flex space-between px-1 md:w-4/6">
        {{ __('trainings.evaluations.evaluation_of_need_for_further_training_details_no') }}
    </div>
    <div x-show="choice === '0'" class="w-full mt-4 px-1 md:w-2/6 text-center">
        <textarea id="evaluation_comment" name="evaluation_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('Leave a comment ...') }}"
        >{{ old('evaluation_comment') }}</textarea>
    </div> --}}
</div>
