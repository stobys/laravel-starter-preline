<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Generator as Faker;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(Faker $faker): void
    {
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $users = [
            'batch' => [
                'username'      => 'batch',
                'password'      => 'CannotLoginForSecurityReasons',

                'email'         => 'batch@example.com',
                'first_name'    => 'Batch',
                'last_name'     => 'Batcher',

                'created_at'    => Carbon::now() -> subHour(),
                'updated_at'    => Carbon::now() -> subHour(),
            ],
            'admin' => [
                'username'      => 'admin',
                'password'      => 'Password',

                'email'         => 'admin@example.com',
                'first_name'    => 'Admin',
                'last_name'     => 'Almighty',

                'created_at'    => Carbon::now() -> subHour(),
                'updated_at'    => Carbon::now() -> subHour(),
            ],
            'atobyss'  => [
                'username'      => 'atobyss',
                'password'      => 'Password',

                'email'         => 'atobys@adient.com',
                'first_name'    => 'Sławomir',
                'last_name'     => 'Tobys',

                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ];

        $batch = User::create($users['batch']);
        $batch -> update([
            'is_built_in' => true,
            'password_changed_at' => $faker->dateTimeBetween('-5 months', 'now'),
        ]);

        $admin = User::create($users['admin']);
        $admin -> update([
            'is_built_in' => true,
            'password_changed_at' => $faker->dateTimeBetween('-5 months', '-3 months'),
        ]);
        // $admin -> assignRole('almighty');

        $atobyss = User::create($users['atobyss']);
        $atobyss -> update([
            'password_changed_at' => $faker->dateTimeBetween('-5 months', 'now'),
        ]);

        // User::factory(10)->create();
    }
}
