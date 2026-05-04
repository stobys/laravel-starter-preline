<?php

namespace App\Console\Commands;

use App\Models\NullModel;
use App\Models\TETA\TetaEmployee as TETATetaEmployee;
use App\Models\TETA\TetaMPK;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncTeta extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:teta {model} {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync data with TETA Constelation';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $model  = strtolower($this->argument('model'));
        $id     = $this->argument('id');

        $id = empty($id) ? null : $id;


        $this -> info("Counting models ..\n");

        $progress = new NullModel;
		$collection = collect([]); // -- default empty collection
		$modelsCount = 0;

        switch ($model) {
            // case 'company':
            //     $collection = TetaCompany::all();
            //     $modelsCount = $collection->count();
            // break;

            case 'employee':
            case 'employees':
				$collection = TETATetaEmployee::whereNotNull('data_zatr')
					->when($id, fn($q, $id) =>
						$q -> where('prac_id', 'LIKE', '%'. $id)
							-> orWhere('nr_ew', 'LIKE', '%'. $id)
					)
					-> where(function ($q) {
						$date = Carbon::now() -> subDays(64) -> toDateTimeString();

						$q -> whereNull('data_rozw') -> orWhere('data_rozw', '>', $date);
					})
					-> get();

                $modelsCount = $collection->count();
            break;

            // case 'position':
            // case 'EmployeePosition':
            //     $collection = TetaEmployeePosition::select(['id', 'nazwa'])->get();
            //     $modelsCount = $collection->count();
            // break;

            case 'mpk':
            case 'department':
            case 'departments':
                $collection = TetaMPK::companySwiebodzin() -> get();
                $modelsCount = $collection->count();
            break;
        }

        $progress = $this -> output -> createProgressBar($modelsCount);
        $progress -> setFormat("%current%/%max% [%bar%] %percent:3s%%");

        foreach ($collection as $model) {
            $model -> sync();
            $progress -> advance();
        }

        $progress -> finish();
    }
}
