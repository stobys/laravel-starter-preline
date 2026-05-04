<?php

namespace App\Console\Commands;

use App\Ldap\LdapUser;
use App\Models\Department;
use App\Models\LDAP\GlobalID;
use App\Models\NullModel;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SyncLdap extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:ldap {username?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Users from AD';

    protected $allADAccounts = null;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $username     = $this->argument('username');

        $username = empty($username) ? null : $username;


        $this -> info("Counting models ..\n");

        $progress = new NullModel;

		if($username) {
			$collection = GlobalID::where('samaccountname', $username)->get();
		}
		else {
			$collection = GlobalID::all();
		}

		$modelsCount = $collection->count();

        $progress = $this -> output -> createProgressBar($modelsCount);
        $progress -> setFormat("%current%/%max% [%bar%] %percent:3s%%");

        foreach ($collection as $model) {
            $model -> sync();
            $progress -> advance();
        }

		$userUsernameIDs = User::select('id', 'username')->get()->pluck('id', 'username')->all();

		$managersWithUsers = collect($collection)
						->groupBy(fn($user) => str(explode(',', $user->getFirstAttribute('manager'))[0])->chopStart('CN='))
    					->map(fn($group) => Arr::flatten($group->pluck('cn')->all()))
						->mapWithKeys(function (array $item, $key) use ($userUsernameIDs) {
							return [$userUsernameIDs[$key] ?? 0 => $item];
						});

		$managersWithUsers->map(function ($users, $managerID) {
			if($managerID) {
				User::whereIn('username', $users)->update(['manager_id' => $managerID]);
			}
			else {
				User::whereIn('username', $users)->update(['manager_id' => null]);
			}
		});

        $progress -> finish();
    }

    /**
     * Execute the console command.
     */
    public function handle2()
    {
        $this -> fetchLdapAccounts();

        $this->info("\nTworzenie działow: ");
        $departments = $this -> createDepartments();

        $this->info("\n\nTworzenie pracowników: ");
        $employees = $this -> createEmployees($departments);

        $this->info("\n\nPrzypisywanie managerow do dzialow: ");
        $this -> assignManagersToDepartments($departments, $employees);

        $this->info("\n\nPrzypisywanie managerow do userow: ");
        $this -> assignManagersToUsers($employees);

        $this->info("\n\nFINISHED");
    }

    protected function fetchLdapAccounts() {
        $this -> allADAccounts = GlobalID::select([
            // 'thumbnailphoto',
            'cn',                           // -- global id
            // 'samaccountname',               // -- global id (samaccountname)

            'givenname',                    // -- first name
            'sn',                           // -- last name

            'title',                        // -- job title
            'telephonenumber',              // -- phone number
            'distinguishedname',            // -- CN=,OU=,DC=,DC=
            'displayname',                  // -- display name (first name + last name)
            // 'memberof',
            'department',                   // -- department ; managers display name
            'userprincipalname',            // -- globalid@adient.com
            'mail',                         // -- email
            'manager',                      // -- manager's CN=,OU=,DC=,DC=
			'mobile', 						// -- mobile phone number

            // 'manageruniqueid',              // -- manager like U2734997
            // 'jcihrmanageruniqueid',          // -- HR manager like U2734997
            // 'jcijobfunctiondescription',     // - ie: Supply Chain & Procurement
            // 'jcibusinesstitledescription',   // - ie: Materials Planner
            // 'jcijobfamilydescription',       // - ie: Materials Mgmt / Invent Cntrl
        ])
        // -> limit(10)
        -> get()
        -> mapWithKeys(function ($ldapUser) {
            return [$ldapUser -> getFirstAttribute('displayname') => [
                'department' => $ldapUser -> getFirstAttribute('department'),
                'username' => $ldapUser -> getFirstAttribute('cn'),

                'full_name' => $ldapUser -> getFirstAttribute('displayname'),
                'first_name' => $ldapUser -> getFirstAttribute('givenname'),
                'last_name' => $ldapUser -> getFirstAttribute('sn'),

                'email' => $ldapUser -> getFirstAttribute('mail'),
            ]];
        });
    }

    protected function createDepartments() {
        $departments = $this -> allADAccounts -> unique('department') -> pluck('department') -> filter();
        $departmentsBar = $this->output->createProgressBar(count($departments));
        $departmentsBar->start();

        $departments =  $departments->mapWithKeys(function ($department) use ($departmentsBar) {
            $model = Department::firstOrCreate(
                ['name' => $department],	        // attributes to look for
                ['abbr' => Str::slug($department)],	// attributes to set if creating
            );

            $departmentsBar->advance();
            return [$department => $model -> id];
        });
        $departmentsBar->finish();

        return $departments;
    }

    protected function createEmployees($departments = []) {

        $employeesBar = $this->output->createProgressBar(count($this->allADAccounts));
        $employeesBar->start();

        $employees = $this->allADAccounts -> mapWithKeys(function ($account) use ($departments, $employeesBar) {
            $password = app()->environment('local') ? 'Password' : Str::random(10);

            $model = User::firstOrCreate(
                    [ 'username' => $account['username'] ],	// attributes to look for
                    [
                        'department_id' => $departments[$account['department']] ?? null, // $departmentModel->id,
                        'password' => Hash::make($password),
                        'email' => $account['email'],
                        'first_name' => $account['first_name'],
                        'last_name' => $account['last_name'],
                    ],	// attributes to set if creating
                );

            $employeesBar->advance();
            return [$account['full_name'] => $model -> id];
        });
        $employeesBar->finish();

        return $employees;
    }

    protected function assignManagersToDepartments($departments = null, $employees = null) {
        if( $departments === null || $employees === null ) {
            return;
        }

        $departmentManagersBar = $this->output->createProgressBar(count($departments));
        $departmentManagersBar->start();
        $departments -> map(function ($id, $name) use ($employees, $departmentManagersBar) {
            $model = Department::find($id);
            if( $model ) {
                $model -> manager_id = $employees[$name] ?? null;
                $model -> save();
            }
            $departmentManagersBar->advance();
        });
        $departmentManagersBar->finish();
    }

    protected function assignManagersToUsers($employees = null) {
        if( $employees === null ) {
            return;
        }

        $userManagersBar = $this->output->createProgressBar(count($employees));
        $userManagersBar->start();
        $employees -> map(function ($id, $name) use ($employees, $userManagersBar) {
            $model = User::find($id);
            if( $model ) {
                $model -> manager_id = $employees[$name] ?? null;
                $model -> save();
            }
            $userManagersBar->advance();
        });
        $userManagersBar->finish();
    }
}
