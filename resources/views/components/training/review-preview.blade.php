<section>
    <div class="overflow-x-auto">
        <div class="grid grid-cols-1 px-2 pt-4 xl:grid-cols-4 xl:gap-4 dark:bg-gray-900">
            <!-- Right Content -->
            <div class="col-span-full xl:col-auto">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-xl font-semibold dark:text-white">{{ __('Training Information') }}</h3>
                    <hr class="mb-4">
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-1 md:w-1/3 font-bold text-right">
                            {{ __('trainings.th.title') }}:
                        </div>
                        <div class="w-full px-1 md:w-2/3">
                            {{ $training->title }}
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-1 md:w-1/3 font-bold text-right">
                            {{ __('trainings.th.period') }}:
                        </div>
                        <div class="w-full px-1 md:w-2/3">
                            {{ $training->fiscal_date }}
                        </div>
                    </div>
                    <div class="flex flex-wrap mb-6">
                        <div class="w-full px-1 md:w-1/3 font-bold text-right">
                            {{ __('trainings.th.planned_cost') }} :
                        </div>
                        <div class="w-full px-1 md:w-2/3">
                            {{ Number::format($training->planned_cost, locale: app()->getLocale()) }}
                        </div>
                    </div>
                </div>
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="text-xl font-semibold dark:text-white">{{ __('Additional Comment') }}</h3>
                    <p class="text-adient-teal-3 mb-4 dark:text-gray-400 text-sm">{{ __('This section is optional') }}</p>
                    <hr class="mb-4">
                    <div class="flex flex-wrap mb-6">
                        <textarea readonly id="evaluation_comment" name="evaluation_comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{ __('No comment left.') }}">{{ $training->evaluation->evaluation_comment }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-span-3">
                    <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                        <div class="flex flex-wrap items-center py-4 hover:bg-gray-100">
                            <div class="w-full px-1 md:w-7/12">
                                <h3 class="mb-4 text-xl font-semibold dark:text-white">{{ __('Evaluation') }}</h3>
                            </div>
                            <div class="w-full px-1 md:w-1/12">
                                <div class="flex items-center me-4 text-center">
                                    {{ __('trainings.reviews.eval_stronly_disagree') }}
                                </div>
                            </div>
                            <div class="w-full px-1 md:w-1/12">
                                <div class="flex items-center me-4 text-center">
                                    {{ __('trainings.reviews.eval_disagree') }}
                                </div>
                            </div>
                            <div class="w-full px-1 md:w-1/12">
                                <div class="flex items-center me-4 text-center">
                                    {{ __('trainings.reviews.eval_neutral') }}
                                </div>
                            </div>
                            <div class="w-full px-1 md:w-1/12">
                                <div class="flex items-center me-4 text-center">
                                    {{ __('trainings.reviews.eval_agree') }}
                                </div>
                            </div>
                            <div class="w-full px-1 md:w-1/12">
                                <div class="flex items-center me-4 text-center">
                                    {{ __('trainings.reviews.eval_stronly_agree') }}
                                </div>
                            </div>
                        </div>

                        <hr class="mb-4">

                        <x-review-question-preview name="evaluation_of_meeting_expectations" :value="$training->evaluation->evaluation_of_meeting_expectations">
                            {{ __('trainings.reviews.evaluation_of_meeting_expectations') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_application_of_acquired_information_at_work" :value="$training->evaluation->evaluation_of_application_of_acquired_information_at_work">
                            {{ __('trainings.reviews.evaluation_of_application_of_acquired_information_at_work') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_the_use_of_training_time" :value="$training->evaluation->evaluation_of_the_use_of_training_time">
                            {{ __('trainings.reviews.evaluation_of_the_use_of_training_time') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_recommendations_for_other_employees" :value="$training->evaluation->evaluation_of_recommendations_for_other_employees">
                            {{ __('trainings.reviews.evaluation_of_recommendations_for_other_employees') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_instructor_prepatation_to_conduct" :value="$training->evaluation->evaluation_of_instructor_prepatation_to_conduct">
                            {{ __('trainings.reviews.evaluation_of_instructor_prepatation_to_conduct') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_local_and_technical_conditions" :value="$training->evaluation->evaluation_of_local_and_technical_conditions">
                            {{ __('trainings.reviews.evaluation_of_local_and_technical_conditions') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_overall_preparation" :value="$training->evaluation->evaluation_of_overall_preparation">
                            {{ __('trainings.reviews.evaluation_of_overall_preparation') }}
                        </x-review-question-preview>

                        <x-review-question-preview name="evaluation_of_training_materials_and_their_use_at_work" :value="$training->evaluation->evaluation_of_training_materials_and_their_use_at_work">
                            {{ __('trainings.reviews.evaluation_of_training_materials_and_their_use_at_work') }}
                        </x-review-question-preview>

                        <hr class="mb-4">

                        <div class="flex flex-wrap py-4 items-center hover:bg-gray-100">
                            <div class="w-full px-1 md:w-7/12">
                                <h3 class="text-xl font-semibold dark:text-white">{{ __('Evaluation Average Score') }}</h3>
                            </div>
                            <div class="w-full px-1 md:w-5/12 text-center">
                                <h1 class="text-2xl font-bold">
                                    {{ Number::format($training->evaluation->evaluation_average, precision: 2, locale: app()->getLocale()) }}
                                </h1>
                            </div>
                        </div>


                    </div>
            </div>
        </div>
    </div>
</section>
