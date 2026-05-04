<?php

namespace App\Services\Tasks;

use App\Models\Department;
use App\Models\User;
use App\Services\Tasks\TaskResult;

class MakeUserDepartmentManagerRalations extends BaseServiceTask
{
    public function name(): string { return 'Ustawianie Relacji'; }
    public function description(): string { return 'Poustawiaj relacje User/Department/Manager'; }
    public function parameters(): array { return []; }  // brak parametrów

    public function run(array $params = []): TaskResult
    {
		$departments = [
			'it' 	=> Department::select('id')->whereTetaMpkCode('06-8324')->firstOrFail(),
			'hr' 	=> Department::select('id')->whereTetaMpkCode('06-8342')->firstOrFail(),
			'qs' 	=> Department::select('id')->whereTetaMpkCode('06-2420')->firstOrFail(),
			'av' 	=> Department::select('id')->whereTetaMpkCode('06-2210')->firstOrFail(),
			'ih' 	=> Department::select('id')->whereTetaMpkCode('06-3110')->firstOrFail(),
			'log'	=> Department::select('id')->whereTetaMpkCode('06-2310')->firstOrFail(),
			'fico'	=> Department::select('id')->whereTetaMpkCode('06-8357')->firstOrFail(),
		];

		$managers = [
			'it' 	=> User::select('id')->whereUsername('akrasig')->firstOrFail(),
			'hr' 	=> User::select('id')->whereUsername('abojanpa')->firstOrFail(),
			'qs' 	=> User::select('id')->whereUsername('agrelam')->firstOrFail(),
			'av' 	=> User::select('id')->whereUsername('abarang')->firstOrFail(),
			'ih' 	=> User::select('id')->whereUsername('amicha64')->firstOrFail(),
			'log'	=> User::select('id')->whereUsername('aschubiz')->firstOrFail(),
			'fico'	=> User::select('id')->whereUsername('azywerm')->firstOrFail(),
		];

		$departments['it']->update(['manager_id' => $managers['it']->id]);
		$departments['hr']->update(['manager_id' => $managers['hr']->id]);
		$departments['qs']->update(['manager_id' => $managers['qs']->id]);
		$departments['av']->update(['manager_id' => $managers['av']->id]);
		$departments['ih']->update(['manager_id' => $managers['ih']->id]);
		$departments['log']->update(['manager_id' => $managers['log']->id]);
		$departments['fico']->update(['manager_id' => $managers['fico']->id]);

		User::whereIn('username', [
			'akrasig', 'atobyss', 'akondrlu', 'aslomkpi'
		])->update(['department_id' => $departments['it']->id]);

		User::whereIn('username', [
			'abojanpa', 'achiechmo', 'ahorowwe', 'apancza1', 'agorczj', 'acale'
		])->update(['department_id' => $departments['hr']->id]);

		User::whereIn('username', [
			'agrelam', 'amileswo', 'abartea1', 'amitelp', 'agrycm', 'apiwonr'
		])->update(['department_id' => $departments['qs']->id]);

		User::whereIn('username', [
			'abarang', 'akarnid', 'astechs', 'awasilp', 'alemiem'
		])->update(['department_id' => $departments['av']->id]);

		User::whereIn('username', [
			'amicha64', 'abrejws', 'akarasp', 'abratkw', 'amaleca1'
		])->update(['department_id' => $departments['ih']->id]);

		User::whereIn('username', [
			'aschubiz', 'asajdym', 'aprochkr', 'aorlicse', 'abarnapa'
		])->update(['department_id' => $departments['log']->id]);

		User::whereIn('username', [
			'azywerm', 'arudkom'
		])->update(['department_id' => $departments['fico']->id]);


        return TaskResult::ok('Znalezionych działów : '. count($departments), ['deleted_count' => 1]);
    }
}
