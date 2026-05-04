<?php

namespace App\Mail;

use App\Console\Commands\AuditSecurityCommand;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class SecurityAuditReport extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $vulnerabilities;
    public array $stats;
    public string $scannedAt;

    public function __construct(Collection $vulnerabilities, string $scannedAt = '')
    {
        $this->vulnerabilities = $vulnerabilities;
        $this->scannedAt       = $scannedAt ?: now()->format('d.m.Y H:i');

        $by = $vulnerabilities->groupBy('severity');
        $this->stats = [
            'total'    => $vulnerabilities->count(),
            'critical' => $by->get('critical', collect())->count(),
            'high'     => $by->get('high', collect())->count(),
            'medium'   => $by->get('medium', collect())->count(),
            'low'      => $by->get('low', collect())->count(),
        ];
    }

    public function envelope(): Envelope
    {
        $urgency = ($this->stats['critical'] + $this->stats['high']) > 0
            ? '[KRYTYCZNE] '
            : '[Ostrzeżenie] ';

        return new Envelope(
            subject: "{$urgency}Security Audit – {$this->stats['total']} luk/ę w " . config('app.name'),
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.security-audit-report');
    }
}
