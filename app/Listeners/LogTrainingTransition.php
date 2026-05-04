<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Attributes\ListensTo;
use Illuminate\Queue\InteractsWithQueue;

use Spatie\ModelStates\Events\StateChanged;

#[ListensTo(StateChanged::class)]
class LogTrainingTransition
{
    // -- Create the event listener.
    public function __construct() {}

    // -- Handle the event.
    public function handle(StateChanged $event): void
    {
		// - $event->initialState	- references to the initial state
		// - $event->finalState		- the new state
		// - $event->transition		- the transition class that performed the transition
		// - $event->model			- the model that the transition was performed on
		// - $event->field			- the field name that was transitioned

        // match( $event->getDecision() ) {
        //     'approval' => $this->sendApprovalNotification($event),
        //     'rejection' => $this->sendRejectionNotification($event),
        //     'pending' => $this->sendPendingNotification($event),
        // };
    }

}
