<?php

namespace App\Listeners;

use App\Events\TrainingParticipantApproved;
use App\Events\TrainingParticipantRejected;
use App\Models\Training;
use App\Notifications\ParticipantDecisionNotification;
use App\States\Trainings\Approved;
use App\States\Trainings\Rejected;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Attributes\ListensTo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

#[ListensTo(TrainingParticipantApproved::class)]
#[ListensTo(TrainingParticipantRejected::class)]
class CheckIfAllParticipantsDecided
{
    public function handle(TrainingParticipantApproved|TrainingParticipantRejected $event): void
    {
        $training = $event->pivot->training;

        $allRejected = $training->participants()->wherePivotNull('rejected_at')->doesntExist();
        $allApproved = $training->participants()->wherePivotNull('approved_at')->doesntExist();

		$allDecided = $training->participants()->wherePivotNull('approved_at')->wherePivotNull('rejected_at')->doesntExist();

		DB::transaction(function () use ($training, $allRejected, $allApproved, $allDecided) {
			$training = Training::lockForUpdate()->find($training->id);
			if ($allRejected) {
				$training->state->transitionTo(Rejected::class);
			}
			else if ($allApproved || $allDecided) {
				$training->state->transitionTo(Approved::class);
			}
		});
    }
}
