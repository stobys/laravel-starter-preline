<?php

namespace App\Collections;

use App\Models\NotificationSetting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class NotificationSettingCollection extends Collection
{
	protected static $all_items = [
		'budget'	=> [
			'budget-exceeded',
		],
		'trainings-managers'		=> [
			'subordinate-participation-approval-required',
		],
		'trainings-participants'	=> [
			'participation-approved-by-manager',
			'participation-rejected-by-manager',
			'participant-review-request',
		],
	];

    public function for(string $action): NotificationSetting
    {
        return $this->get($action)
            ?? (new NotificationSetting)->forceFill(
                ['action' => $action, ...NotificationSetting::defaults()]
            );
    }

	public static function forUser(int $user_id): static
	{
		$items = NotificationSetting::whereUserId($user_id)->get()->keyBy('action');

		return new static($items->all());
	}

	public static function getAllItems() {
		return self::$all_items;
	}

	public static function saveSettings() {
		$defaults = NotificationSetting::defaults();
		$settings = request()->get('settings');
		$flatSettings = Arr::flatten(self::getAllItems());

		foreach($flatSettings as $setting )
		{
			NotificationSetting::updateOrCreate([
				'user_id' => auth()->id(),
				'action' => $setting,
			], [
				'email' => in_array('email', $settings[$setting] ?? []),
				'sms' => in_array('sms', $settings[$setting] ?? []),
				'in_app' => in_array('in_app', $settings[$setting] ?? []),
			]);
		}
	}

	public static function setSetting(string $action, string $channel, bool $value) {
		NotificationSetting::updateOrCreate([
			'user_id' => auth()->id(),
			'action' => $action,
		], [
			$channel => $value
		]);
	}
}
