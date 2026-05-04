<?php

namespace App\Listeners;

use Illuminate\Events\Attributes\ListensTo;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;

#[ListensTo(TakeImpersonation::class)]
#[ListensTo(LeaveImpersonation::class)]
class LogImpersonateActivity
{
    // -- Create the event listener.
    public function __construct() {}

    // -- Handle the event.
    public function handle(TakeImpersonation|LeaveImpersonation $event): void
    {
		if ($event instanceof TakeImpersonation) {
			// logika dla wejścia
			$this->logTakingImpersonation($event);
		}

		if ($event instanceof LeaveImpersonation) {
			// logika dla wyjścia
			$this->logLeavingImpersonation($event);
		}
    }

    private function logTakingImpersonation(TakeImpersonation $event): void
    {
		// Each events returns two properties $event->impersonator and $event->impersonated containing User model instance.
    }

    private function logLeavingImpersonation(LeaveImpersonation $event): void
    {
		// Each events returns two properties $event->impersonator and $event->impersonated containing User model instance.
    }

}
