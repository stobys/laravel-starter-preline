        <div class="flex flex-col gap-5 xl:flex-row xl:items-center xl:justify-between">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <ul class="mx-auto grid max-w-md grid-cols-1 gap-10 lg:max-w-5xl lg:grid-cols-6">
                    <li class="flex-start group relative flex lg:flex-col">
                        <span
                            class="absolute left-[18px] top-14 h-[calc(100%_-_32px)] w-px bg-gray-300 lg:right-0 lg:left-auto lg:top-[18px] lg:h-px lg:w-[calc(100%_-_72px)]"
                            aria-hidden="true"></span>
                        <div @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300',
                            'bg-green-200' => $training->submitted_by,
                            'bg-gray-20' => !$training->submitted_by,
                            'transition-all duration-200'])
                        >
                            @if( $training->submitted_by )
                                @svg('feather-check-circle', 'h-5 w-5 text-gray-600')
                            @else
                                @svg('feather-circle', 'h-5 w-5 text-gray-600')
                            @endif
                        </div>
                        <div class="ml-6 lg:ml-0 lg:mt-4">
                            <h5 class="text-sm font-bold text-gray-500 dark:text-gray-400 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500">
                                DM submission
                            </h5>
                            @if( $training->submitted_by )
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->submitted_at }}
                                </p>
                                <p class="text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->submittedBy->full_name }}
                                </p>
                            @else
                                <h4 class="mt-2 text-sm text-base text-gray-700">Pending</h4>
                            @endif
                        </div>
                    </li>
                    <li class="flex-start group relative flex lg:flex-col">
                        <span
                            class="absolute left-[18px] top-14 h-[calc(100%_-_32px)] w-px bg-gray-300 lg:right-0 lg:left-auto lg:top-[18px] lg:h-px lg:w-[calc(100%_-_72px)]"
                            aria-hidden="true"></span>
                        <div @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300',
                            'bg-green-200' => $training->hr_approved_by,
                            'bg-gray-20' => !$training->hr_approved_by,
                            'transition-all duration-200'])
                        >
                            @if( $training->hr_approved_by )
                                @svg('feather-check-circle', 'h-5 w-5 text-gray-600')
                            @else
                                @svg('feather-circle', 'h-5 w-5 text-gray-600')
                            @endif
                        </div>
                        <div class="ml-6 lg:ml-0 lg:mt-4">
                            <h5
                                class="text-sm font-bold text-gray-500 dark:text-gray-400 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500">
                                HR Approval
                            </h5>
                            @if( $training->hr_approved_by )
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->hr_approved_at }}
                                </p>
                                <p class="text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->hrApprovedBy->full_name }}
                                </p>
                            @else
                                <h4 class="mt-2 text-sm text-base text-gray-700">Pending</h4>
                            @endif
                        </div>
                    </li>
                    <li class="flex-start group relative flex lg:flex-col">
                        <span
                            class="absolute left-[18px] top-14 h-[calc(100%_-_32px)] w-px bg-gray-300 lg:right-0 lg:left-auto lg:top-[18px] lg:h-px lg:w-[calc(100%_-_72px)]"
                            aria-hidden="true"></span>
                        <div @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300',
                            'bg-green-200' => $training->fico_approved_by,
                            'bg-gray-20' => !$training->fico_approved_by,
                            'transition-all duration-200'])
                        >
                            @if( $training->fico_approved_by )
                                @svg('feather-check-circle', 'h-5 w-5 text-gray-600')
                            @else
                                @svg('feather-circle', 'h-5 w-5 text-gray-600')
                            @endif
                        </div>
                        <div class="ml-6 lg:ml-0 lg:mt-4">
                            <h5
                                class="text-sm font-bold text-gray-500 dark:text-gray-400 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500">
                                FICO Approval
                            </h5>
                            @if( $training->fico_approved_by )
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->fico_approved_at }}
                                </p>
                                <p class="text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->ficoApprovedBy->full_name }}
                                </p>
                            @else
                                <h4 class="mt-2 text-sm text-base text-gray-700">Pending</h4>
                            @endif
                        </div>
                    </li>
                    <li class="flex-start group relative flex lg:flex-col">
                        <span
                            class="absolute left-[18px] top-14 h-[calc(100%_-_32px)] w-px bg-gray-300 lg:right-0 lg:left-auto lg:top-[18px] lg:h-px lg:w-[calc(100%_-_72px)]"
                            aria-hidden="true"></span>
                        <div @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300',
                            'bg-green-200' => $training->pm_approved_by,
                            'bg-gray-20' => !$training->pm_approved_by,
                            'transition-all duration-200'])
                        >
                            @if( $training->pm_approved_by )
                                @svg('feather-check-circle', 'h-5 w-5 text-gray-600')
                            @else
                                @svg('feather-circle', 'h-5 w-5 text-gray-600')
                            @endif
                        </div>
                        <div class="ml-6 lg:ml-0 lg:mt-4">
                            <h5
                                class="text-sm font-bold text-gray-500 dark:text-gray-400 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500">
                                PM Approval
                            </h5>
                            @if( $training->pm_approved_by )
                                <p class="mb-2 text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->pm_approved_at }}
                                </p>
                                <p class="text-xs leading-normal text-gray-500 dark:text-gray-400">
                                    {{ $training->pmApprovedBy->full_name }}
                                </p>
                            @else
                                <h4 class="mt-2 text-sm text-base text-gray-700">Pending</h4>
                            @endif
                        </div>
                    </li>
                    <li class="flex-start group relative flex lg:flex-col">
                        <div @class(['inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300',
                            'bg-green-200' => $training->state->isFullyApproved(),
                            'bg-gray-20' => !$training->state->isFullyApproved(),
                            'transition-all duration-200'])
                        >
                            @if( $training->state->isFullyApproved() )
                                @svg('feather-check-circle', 'h-5 w-5 text-gray-600')
                            @else
                                @svg('feather-circle', 'h-5 w-5 text-gray-600')
                            @endif
                        </div>
                        <div class="ml-6 lg:ml-0 lg:mt-4">
                            <h5
                                class="text-sm font-bold text-gray-500 dark:text-gray-400 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500">
                                Fully Approved
                            </h5>
                            <h6 class="mt-2 text-sm text-base text-gray-700"></h6>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
