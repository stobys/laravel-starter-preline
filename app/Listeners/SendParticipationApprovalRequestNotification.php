<?php

namespace App\Listeners;

use App\Events\TrainingSubmitedForApproval;
use App\Models\Training;
use App\Notifications\ParticipationApprovalRequestNotification;
use Illuminate\Events\Attributes\ListensTo;

#[ListensTo(TrainingSubmitedForApproval::class)]
class SendParticipationApprovalRequestNotification
{
    // -- Create the event listener.
    public function __construct() {}

    // -- Handle the event.
    public function handle(TrainingSubmitedForApproval $event): void
    {
		// -- Podejście: eager loading z grupowaniem
		$training = Training::with([
			'participants.department.manager'
		])->findOrFail($event->training->id);

		// Grupujemy uczestników po managerze
		$byManager = $training->participants
			->groupBy(fn($participant) => $participant->department->manager_id)
			->map(fn($participants, $managerId) => [
				'manager'      => $participants->first()->department->manager,
				'participants' => $participants,
			]);

		foreach($byManager as $department) {
			$manager = $department['manager'];
			$participants = $department['participants'];

			// TODO: Wysłanie powiadomienia do managera
			$manager->notify(new ParticipationApprovalRequestNotification($training, $participants));
		}
    }

}

