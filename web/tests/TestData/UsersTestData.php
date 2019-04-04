<?php

namespace Tests\TestData;

use UserSeeder;

trait UsersTestData
{
    public static $user1 = [
        'id' => 1,
        'email' => 'customer1@example.com',
        'name' => 'First Customer',
        'password' => UserSeeder::USER_PASSWORD,
        'email_verified_at' => '2019-01-01 00:00:00',
    ];

    public static $user2 = [
        'id' => 2,
        'email' => 'customer2@example.com',
        'name' => 'Second Customer',
        'password' => UserSeeder::USER_PASSWORD,
        'email_verified_at' => '2019-01-01 00:00:00',
    ];

    public static function getUsersData(): array
    {
        return [
            self::$user1,
            self::$user2,
        ];
    }
}
