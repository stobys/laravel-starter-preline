<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $departments = [
            'it' => [
                    'name'      => 'Dział IT',
                    'abbr'      => 'IT',

                    'created_at'    => Carbon::now() -> subHour(),
                    'updated_at'    => Carbon::now() -> subHour(),
                ],
            'hr' => [
                    'name'      => 'Dział Personalny',
                    'abbr'      => 'HR',

                    'created_at'    => Carbon::now() -> subHour(),
                    'updated_at'    => Carbon::now() -> subHour(),
                ],
            'me'  => [
                    'name'      => 'Dział Przygotowania Produkcji',
                    'abbr'      => 'AV',

                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
            'qs'  => [
                    'name'      => 'Dział Zapewnienia Jakości',
                    'abbr'      => 'QS',

                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ],
        ];

        $it = Department::create($departments['it']);
        $hr = Department::create($departments['hr']);
        $me = Department::create($departments['me']);
        $qs = Department::create($departments['qs']);

        // $akrasig = User::whereUsername('akrasig')->first();
        // $akrasig -> update(['department_id' => $it->id]);
        // $atobyss = User::whereUsername('atobyss')->first();
        // $atobyss -> update(['department_id' => $it->id]);

        // $abojanpa = User::whereUsername('abojanpa')->first();
        // $abojanpa -> update(['department_id' => $hr->id]);
        // $ahorowwe = User::whereUsername('ahorowwe')->first();
        // $ahorowwe -> update(['department_id' => $hr->id]);

        // $abarang = User::whereUsername('abarang')->first();
        // $abarang -> update(['department_id' => $me->id]);
        // $astechs = User::whereUsername('astechs')->first();
        // $astechs -> update(['department_id' => $me->id]);

        // $agrelam = User::whereUsername('agrelam')->first();
        // $agrelam -> update(['department_id' => $qs->id]);
        // $amitelp = User::whereUsername('amitelp')->first();
        // $amitelp -> update(['department_id' => $qs->id]);

        // $it -> update(['manager_id' => $akrasig->id]);
        // $hr -> update(['manager_id' => $abojanpa->id]);
        // $me -> update(['manager_id' => $abarang->id]);
        // $qs -> update(['manager_id' => $agrelam->id]);


    }
}
