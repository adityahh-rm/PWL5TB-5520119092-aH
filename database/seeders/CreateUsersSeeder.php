<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => "isUser",
                'username' => 'User',
                'email' => "user@mail.com",
                'password' => Hash::make(123456),
                'photo' => 'user.jpg',
                'roles_id' => 2
            ],
            [
                'name' => "isAdmin",
                'username' => 'Admin',
                'email' => "admin@mail.com",
                'password' => Hash::make(123456),
                'photo' => 'admin.jpg',
                'roles_id' => 1
            ]
        ];

        foreach($user as $key => $value) {
            User::create($value);
        }
    }
}
