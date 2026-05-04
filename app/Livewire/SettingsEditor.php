<?php

namespace App\Livewire;

use App\Collections\NotificationSettingCollection;
use App\Services\AppService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsEditor extends Component
{
    use WithFileUploads;

    protected $appService;

	public string $activeTab = '';

    // #[Rule('required|string|max:255')]
    // public $first_name;

	public $notificationSettings = null;

	public array $settingsNames = [];

    public function boot(AppService $appService)
    {
        // $this -> appService = $appService;
		$this->activeTab = session('settingsActiveTab', 'tabs-with-underline-2');

		$this -> notificationSettings = NotificationSettingCollection::forUser(auth()->id());


		$flatSettings = Arr::flatten(NotificationSettingCollection::getAllItems());
		foreach($flatSettings as $setting )
		{
			$this->settingsNames[$setting] = [
				'email' => $this->notificationSettings->for($setting)->email,
				'sms' => $this->notificationSettings->for($setting)->sms,
				'in_app' => $this->notificationSettings->for($setting)->in_app,
			];
		}
    }

    public function mount()
    {
    }


	public function updated(string $name, mixed $value): void
	{

	}

    public function render()
    {
        $availableLanguages = []; // $this->appService->getAvailableLanguages();

        return view('livewire.user-settings', compact('availableLanguages'))
                ->layout('layout.main');
    }

	// #[Renderless]
	public function setSetting(string $action, string $channel, bool $value)
	{
		NotificationSettingCollection::setSetting($action, $channel, $value);

		$this->settingsNames[$action][$channel] = $value;

		// Update the corresponding property
		// $camelCaseName = str($action . '-' . $channel)->camel();
		// $this->$camelCaseName = $value;
	}

	public function setActiveTab(string $tab) {
		$this->activeTab = $tab;

		session(['settingsActiveTab' => $tab]);
	}
}
