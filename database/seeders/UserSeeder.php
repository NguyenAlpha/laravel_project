<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'nhat nguyen',
                'password' => Hash::make('password'),
                'email' => 'password@gmail.com',
                'role' => 'customer',
                'sex' => 'nam',
                'phone_number' => '0963944370',
                'dob' => '2005-04-27',
                'status' => 'mở',
                'created_at' =>'2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ],
            [
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'sex' => 'nam',
                'phone_number' => '0123456789',
                'dob' => '2005-05-15',
                'status' => 'mở',
                'created_at' =>'2025-09-5 12:34:21',
                'updated_at' => '2025-09-5 12:34:21',
                'avatar_url' => ''
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
