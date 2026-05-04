<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AlmightyAssign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'almighty:assign {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Almighty Role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::where('username', $this->argument('username'))->firstOrFail();
        $user->assignRole('almighty');

        $this->info('Almighty role assigned to user: ' . $user->username);
    }
}
