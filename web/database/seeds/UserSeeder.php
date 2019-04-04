<?php

use Illuminate\Database\Seeder;
use Tests\TestConstants;

class UserSeeder extends Seeder
{
    public const USER_PASSWORD = "12dfD478";

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(User::class, 1)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $usersTestData = array_map(function ($user) {
            return array_merge($user, ['password' => Hash::make($user['password'])]);
        }, TestConstants::getUsersData());

        foreach ($usersTestData as $user) {
            \App\Models\User::forceCreate($user);
        }
    }
}
