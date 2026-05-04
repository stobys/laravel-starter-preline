<?php

namespace App\Livewire;

use Livewire\Component;

class InactivityWatcher extends Component
{
    public int $timeout = 900;
    public int $warningBefore = 60;

    public function mount(): void
    {
        $this->timeout = config('session.lifetime', 900);
        $this->warningBefore = 60;
    }

    public function logout(): void
    {
		// -- @TODO : log the inactivity logout
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->redirect(route('login'), navigate: true);
    }

    public function render()
    {
        return view('livewire.inactivity-watcher');
    }

	public function keepAlive(): void
	{
		// sama obecność wywołania odświeża sesję Laravel
	}
}
