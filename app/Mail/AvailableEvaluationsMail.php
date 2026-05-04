<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class AvailableEvaluationsMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Collection $evaluations,
        public readonly string $managerName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[HeRMeS] Zaległe oceny do wykonania – ' . now()->format('d.m.Y'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.available-evaluations',
        );
    }
}
