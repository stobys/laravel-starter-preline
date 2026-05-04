<?php

namespace App\Listeners;

use App\Events\TrainingParticipantApproved;
use App\Events\TrainingParticipantRejected;
use App\Notifications\ParticipantDecisionNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Attributes\ListensTo;
use Illuminate\Queue\InteractsWithQueue;

#[ListensTo(TrainingParticipantApproved::class)]
#[ListensTo(TrainingParticipantRejected::class)]
class SendParticipantManagerDecisionNotification implements ShouldQueue
{
    // -- Create the event listener.
    public function __construct() {}

    // -- Handle the event.
    public function handle(TrainingParticipantApproved|TrainingParticipantRejected $event): void
    {
        match( $event->getDecision() ) {
            'approval' => $this->sendApprovalNotification($event),
            'rejection' => $this->sendRejectionNotification($event),
            'pending' => $this->sendPendingNotification($event),
        };
    }

    private function sendApprovalNotification(TrainingParticipantApproved $event): void
    {
        $event->pivot->participant->notify(
            new ParticipantDecisionNotification($event->pivot, 'approval')
        );
    }

    private function sendRejectionNotification(TrainingParticipantRejected $event): void
    {
        $event->pivot->participant->notify(
            new ParticipantDecisionNotification($event->pivot, 'rejection')
        );
    }

    private function sendPendingNotification(TrainingParticipantApproved|TrainingParticipantRejected $event): void
    {
        // logika dla oczekiwania
    }
}
