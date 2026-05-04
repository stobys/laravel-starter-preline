<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestMail extends Command
{
    protected $signature = 'mail:test';
    protected $description = 'Wysyła testowego maila na podany adres';

    public function handle(): void
    {
        $email = $this->ask('Na jaki adres wysłać maila?');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Nieprawidłowy adres email.');
            return;
        }

        $this->info("Wysyłam maila na: {$email}...");

        try {
            Mail::to($email)->send(new TestMail());
            $this->info('Mail wysłany pomyślnie!');
        } catch (\Exception $e) {
            $this->error("Błąd: {$e->getMessage()}");
        }
    }
}
