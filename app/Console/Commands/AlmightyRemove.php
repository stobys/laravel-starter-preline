<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AlmightyRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'almighty:remove {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove Almighty Role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('username', $this->argument('username'))->firstOrFail();
        $user->removeRole('almighty');

        $this->info('Almighty role removed from user: ' . $user->username);
    }
}
