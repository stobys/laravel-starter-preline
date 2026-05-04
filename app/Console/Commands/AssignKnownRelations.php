<?php

namespace App\Console\Commands;

use App\Models\Department;
use App\Models\User;
use Illuminate\Console\Command;

class AssignKnownRelations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'relations:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Known User/Department/Manager Relations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
		// -- Działy
		$it = Department::whereTetaMpk('06-8324')->firstOrFail();
		$hr = Department::whereTetaMpk('06-8342')->firstOrFail();
		$qs = Department::whereTetaMpk('06-2420')->firstOrFail();
		$av = Department::whereTetaMpk('06-2210')->firstOrFail();
		$ih = Department::whereTetaMpk('06-3110')->firstOrFail();
		$log = Department::whereTetaMpk('06-2310')->firstOrFail();

		$akrasig = User::whereUsername('akrasig')->firstOrFail();
        $user = User::where('username', $this->argument('username'))->firstOrFail();
        $user->assignRole('almighty');

        $this->info('Almighty role assigned to user: ' . $user->username);
    }
}
