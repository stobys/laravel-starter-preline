
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
                            <div class="w-full flex space-between px-1 md:w-4/6">
                                <h3 class="mb-4 text-xl font-semibold dark:text-white">
                                    {{ __('Effectiveness Evaluation') }}
                                </h3>
                            </div>
                            <div class="w-full px-1 md:w-1/6 text-center text-lg">
                                {{ __('trainings.effectiveness.eval_yes') }}
                            </div>
                            <div class="w-full px-1 md:w-1/6 text-center text-lg">
                                {{ __('trainings.effectiveness.eval_no') }}
                            </div>
                        </div>

                        <hr class="mb-4">

                        <div class="mx-auto space-y-3">
                            <x-training.evaluation_questions.use_of_knowledge_preview :eval="$training->effectiveness" />
                            <hr class="mb-4">
                            <x-training.evaluation_questions.need_of_further_training_preview :eval="$training->effectiveness" />
                        </div>

                    </div>
            </div>
        </div>
    </div>
</section>
