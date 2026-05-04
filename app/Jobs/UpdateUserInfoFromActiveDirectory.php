<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateUserInfoFromActiveDirectory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $username
    ) {}

    public function handle(): void
    {
        $user = User::where('username', $this->username)->first();

        if($user)
        {
            $user->update([
                'name' => 'Jan Kowalski', // z AD
                'email' => 'jan.kowalski@firma.pl', // z AD
            ]);
        }
    }
}
