<!-- Pricing -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 mx-auto">
	<!-- Comparison table -->
		<div id="hs-pricing-comparison-content" class="w-full overflow-hidden transition-[height] duration-300" aria-labelledby="hs-pricing-comparison" role="region">
			<!-- lg+ -->
			<div class="block">
				<table class="w-full h-px">
					<thead class="sticky top-0 inset-x-0 bg-white dark:bg-neutral-800">
						<tr>
							<th class="py-4 ps-6 pe-6 text-sm font-medium text-gray-800 dark:text-neutral-200 text-start" scope="col">
								<div  wire:loading wire:target="setSetting">
									<span class="inline-flex items-center gap-2">
										<x-feather-refresh-cw class="animate-spin shrink-0 size-5" />
										Zapisywanie ustawień ...
									</span>
								</div>
							</th>
							<th class="w-1/5 py-4 px-6 text-lg leading-6 font-medium text-gray-800 dark:text-neutral-200 text-center hs-tooltip [--placement:top]" scope="col">
								<x-feather-mail class="shrink-0 size-5 mx-auto hs-tooltip-toggle" />
								<span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-tooltip border border-tooltip-line text-xs font-medium text-tooltip-foreground rounded-md shadow-2xs" role="tooltip">
									{{ __('settings.labels.email_notification') }}
								</span>
							</th>
							<th class="w-1/5 py-4 px-6 text-lg leading-6 font-medium text-gray-800 dark:text-neutral-200 text-center hs-tooltip [--placement:top]" scope="col">
								<x-feather-message-square class="shrink-0 size-5 mx-auto hs-tooltip-toggle" />
								<span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-tooltip border border-tooltip-line text-xs font-medium text-tooltip-foreground rounded-md shadow-2xs" role="tooltip">
									{{ __('settings.labels.sms_notification') }}<br />Not Implemented Yet
								</span>
							</th>
							<th class="w-1/5 py-4 px-6 text-lg leading-6 font-medium text-gray-800 dark:text-neutral-200 text-center hs-tooltip [--placement:top]" scope="col">
								<x-feather-layout class="shrink-0 size-5 mx-auto hs-tooltip-toggle" />
								<span class="hs-tooltip-content hs-tooltip-shown:opacity-100 hs-tooltip-shown:visible opacity-0 transition-opacity inline-block absolute invisible z-10 py-1 px-2 bg-tooltip border border-tooltip-line text-xs font-medium text-tooltip-foreground rounded-md shadow-2xs" role="tooltip">
									{{ __('settings.labels.in_app_notification') }}<br />Not Implemented Yet
								</span>
							</th>
						</tr>
					</thead>

					<tbody class="border-t border-gray-200 dark:border-neutral-700 divide-y divide-gray-200 dark:divide-neutral-700">
						<tr>
							<th class="py-3 ps-6 bg-gray-50 dark:bg-neutral-800 font-bold text-gray-800 dark:text-neutral-200 text-start" colspan="4" scope="colgroup">
								{{ __('settings.labels.sections.budgets') }}
							</th>
						</tr>

						<tr>
							<th class="py-5 ps-6 pe-6 font-normal text-gray-600 dark:text-neutral-300 text-start whitespace-nowrap" scope="row">
								{{ __('settings.labels.budget-exceeded') }}
							</th>

							<td class="py-5 px-6">
								<x-form.switch value="email" name="settings[budget-exceeded][]" class="mx-auto"
									:checked="Arr::get($settingsNames, 'budget-exceeded.email', false)"
									wire:click="setSetting('budget-exceeded', 'email', {{ Arr::get($settingsNames, 'budget-exceeded.email', false) ? 0 : 1 }})"
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="sms" name="settings[budget-exceeded][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'budget-exceeded.sms', false)"
									wire:click="setSetting('budget-exceeded', 'sms', {{ Arr::get($settingsNames, 'budget-exceeded.sms', false) ? 0 : 1 }})"
									--}}
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="in_app" name="settings[budget-exceeded][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'budget-exceeded.in_app', false)"
									wire:click="setSetting('budget-exceeded', 'in_app', {{ Arr::get($settingsNames, 'budget-exceeded.in_app', false) ? 0 : 1 }})"
									--}}
									/>
							</td>
						</tr>

						<tr>
							<th class="py-3 ps-6 bg-gray-50 dark:bg-neutral-800 font-bold text-gray-800 dark:text-neutral-200 text-start" colspan="4" scope="colgroup">
								{{ __('settings.labels.sections.trainings-managers') }}
							</th>
						</tr>

						<tr>
							<th class="py-5 ps-6 pe-6 text-sm font-normal text-gray-600 dark:text-neutral-300 text-start whitespace-nowrap" scope="row">
								{{ __('settings.labels.subordinate-participation-approval-required') }}
							</th>

							<td class="py-5 px-6">
								<x-form.switch value="email" name="settings[subordinate-participation-approval-required][]" class="mx-auto"
									:checked="Arr::get($settingsNames, 'subordinate-participation-approval-required.email', false)"
									wire:click="setSetting('subordinate-participation-approval-required', 'email', {{ Arr::get($settingsNames, 'subordinate-participation-approval-required.email', false) ? 0 : 1 }})"
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="sms" name="settings[subordinate-participation-approval-required][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'subordinate-participation-approval-required.sms', false)"
									wire:click="setSetting('subordinate-participation-approval-required', 'sms', {{ Arr::get($settingsNames, 'subordinate-participation-approval-required.sms', false) ? 0 : 1 }})"
									--}}
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="in_app" name="settings[subordinate-participation-approval-required][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'subordinate-participation-approval-required.in_app', false)"
									wire:click="setSetting('subordinate-participation-approval-required', 'in_app', {{ Arr::get($settingsNames, 'subordinate-participation-approval-required.in_app', false) ? 0 : 1 }})"
									--}}
								/>
							</td>
						</tr>

						<tr>
							<th class="py-3 ps-6 bg-gray-50 dark:bg-neutral-800 font-bold text-gray-800 dark:text-neutral-200 text-start" colspan="4" scope="colgroup">
								{{ __('settings.labels.sections.trainings-participants') }}
							</th>
						</tr>


						<tr>
							<th class="py-5 ps-6 pe-6 text-sm font-normal text-gray-600 dark:text-neutral-300 text-start whitespace-nowrap" scope="row">
								{{ __('settings.labels.participation-approved-by-manager') }}
							</th>

							<td class="py-5 px-6">
								<x-form.switch value="email" name="settings[participation-approved-by-manager][]" class="mx-auto"
									:checked="Arr::get($settingsNames, 'participation-approved-by-manager.email', false)"
									wire:click="setSetting('participation-approved-by-manager', 'email', {{ Arr::get($settingsNames, 'participation-approved-by-manager.email', false) ? 0 : 1 }})"
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="sms" name="settings[participation-approved-by-manager][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participation-approved-by-manager.sms', false)"
									wire:click="setSetting('participation-approved-by-manager', 'sms', {{ Arr::get($settingsNames, 'participation-approved-by-manager.sms', false) ? 0 : 1 }})"
									--}}
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="in_app" name="settings[participation-approved-by-manager][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participation-approved-by-manager.in_app', false)"
									wire:click="setSetting('participation-approved-by-manager', 'in_app', {{ Arr::get($settingsNames, 'participation-approved-by-manager.in_app', false) ? 0 : 1 }})"
									--}}
								/>
							</td>
						</tr>

						<tr>
							<th class="py-5 ps-6 pe-6 text-sm font-normal text-gray-600 dark:text-neutral-300 text-start whitespace-nowrap" scope="row">
								{{ __('settings.labels.participation-rejected-by-manager') }}
							</th>

							<td class="py-5 px-6">
								<x-form.switch value="email" name="settings[participation-rejected-by-manager][]" class="mx-auto"
									:checked="Arr::get($settingsNames, 'participation-rejected-by-manager.email', false)"
									wire:click="setSetting('participation-rejected-by-manager', 'email', {{ Arr::get($settingsNames, 'participation-rejected-by-manager.email', false) ? 0 : 1 }})"
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="sms" name="settings[participation-rejected-by-manager][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participation-rejected-by-manager.sms', false)"
									wire:click="setSetting('participation-rejected-by-manager', 'sms', {{ Arr::get($settingsNames, 'participation-rejected-by-manager.sms', false) ? 0 : 1 }})"
									--}}
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="in_app" name="settings[participation-rejected-by-manager][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participation-rejected-by-manager.in_app', false)"
									wire:click="setSetting('participation-rejected-by-manager', 'in_app', {{ Arr::get($settingsNames, 'participation-rejected-by-manager.in_app', false) ? 0 : 1 }})"
									--}}
								/>
							</td>
						</tr>

						<tr>
							<th class="py-5 ps-6 pe-6 text-sm font-normal text-gray-600 dark:text-neutral-300 text-start whitespace-nowrap" scope="row">
								{{ __('settings.labels.participant-review-request') }}
							</th>

							<td class="py-5 px-6">
								<x-form.switch value="email" name="settings[participant-review-request][]" class="mx-auto"
									:checked="Arr::get($settingsNames, 'participant-review-request.email', false)"
									wire:click="setSetting('participant-review-request', 'email', {{ Arr::get($settingsNames, 'participant-review-request.email', false) ? 0 : 1 }})"
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="sms" name="settings[participant-review-request][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participant-review-request.sms', false)"
									wire:click="setSetting('participant-review-request', 'sms', {{ Arr::get($settingsNames, 'participant-review-request.sms', false) ? 0 : 1 }})"
									--}}
								/>
							</td>

							<td class="py-5 px-6">
								<x-form.switch value="in_app" name="settings[participant-review-request][]" class="mx-auto"
									:checked="false" :disabled="true"
									{{--
									:checked="Arr::get($settingsNames, 'participant-review-request.in_app', false)"
									wire:click="setSetting('participant-review-request', 'in_app', {{ Arr::get($settingsNames, 'participant-review-request.in_app', false) ? 0 : 1 }})"
									--}}
								/>
							</td>
						</tr>

					</tbody>
				</table>
			</div>
			<!-- End lg+ -->
		</div>

	<!-- End Comparison table -->
</div>
<!-- End Pricing -->
