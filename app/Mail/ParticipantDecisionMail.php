<?php

namespace App\Mail;

use App\Models\Pivots\ParticipantTraining;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class ParticipantDecisionMail extends Mailable
{
    use Queueable, SerializesModels;

    // -- Create a new message instance.
	public function __construct(
        public readonly ParticipantTraining $pivot,
        public readonly string $decision
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'HeRMeS : Participant Decision Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.training.participant-decision',
			with: [
                'participant' => $this->pivot->participant,
                'training'    => $this->pivot->training,
                'manager'     => $this->pivot->participant->department->manager,
                'decision'    => $this->decision,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
