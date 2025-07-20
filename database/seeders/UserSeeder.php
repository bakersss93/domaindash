<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@jargonconsulting.com.au',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'dark_mode' => false,
        ]);

        User::create([
            'first_name' => 'Customer',
            'surname' => 'User',
            'email' => 'customer@jargonconsulting.com.au',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'dark_mode' => false,
        ]);

        User::create([
            'first_name' => 'Tech',
            'surname' => 'User',
            'email' => 'technician@jargonconsulting.com.au',
            'password' => bcrypt('tech'),
            'role' => 'technician',
            'dark_mode' => false,
        ]);
    }
}
