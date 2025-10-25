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
                'user_id' => 1,
                'username' => 'nhat nguyen',
                'password' => Hash::make('password'),
                'email' => 'password@gmail.com',
                'role' => 'customer',
                'sex' => 'nam',
                'phone_number' => '0963944370',
                'dob' => '2005-04-27',
                'status' => 'mở',
                'created_at' => '2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ],
            [
                'user_id' => 2,
                'username' => 'admin',
                'password' => Hash::make('admin'),
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'sex' => 'nam',
                'phone_number' => '0123456789',
                'dob' => '2005-05-15',
                'status' => 'mở',
                'created_at' => '2025-09-5 12:34:21',
                'updated_at' => '2025-09-5 12:34:21',
                'avatar_url' => ''
            ],
            [
                'user_id' => 3,
                'username' => 'thế kiên',
                'password' => Hash::make('password'),
                'email' => 'thekien@gmail.com',
                'role' => 'customer',
                'sex' => 'nữ',
                'phone_number' => '0998877665',
                'dob' => '2005-10-30',
                'status' => 'mở',
                'created_at' => '2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ],
            [
                'user_id' => 4,
                'username' => 'user1',
                'password' => Hash::make('password'),
                'email' => 'user1@gmail.com',
                'role' => 'customer',
                'sex' => 'nam',
                'phone_number' => '0998877001',
                'dob' => '2005-01-01',
                'status' => 'mở',
                'created_at' => '2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ],
            [
                'user_id' => 5,
                'username' => 'user2',
                'password' => Hash::make('password'),
                'email' => 'user2@gmail.com',
                'role' => 'customer',
                'sex' => 'nam',
                'phone_number' => '0998877002',
                'dob' => '2005-02-02',
                'status' => 'mở',
                'created_at' => '2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ],
            [
                'user_id' => 6,
                'username' => 'user3',
                'password' => Hash::make('password'),
                'email' => 'user3@gmail.com',
                'role' => 'customer',
                'sex' => 'nam',
                'phone_number' => '0998877003',
                'dob' => '2005-03-03',
                'status' => 'mở',
                'created_at' => '2025-09-10 12:34:21',
                'updated_at' => '2025-09-10 12:34:21',
                'avatar_url' => ''
            ]
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
