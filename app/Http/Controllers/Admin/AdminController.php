<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createAdmin()
    {
        /*
        User::create([
            'username' => 'admin',
            'email' => "admin@gmail.com",
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'phone_number' => '0123456789'
        ]);
        */
    }
}
