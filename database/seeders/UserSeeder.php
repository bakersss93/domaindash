<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'surname' => 'User',
            'email' => 'admin@jargonconsulting.com.au',
            'password' => bcrypt('admin'),
            'dark_mode' => false,
        ]);
        $admin->assignRole('Administrator');

        $customer = User::create([
            'first_name' => 'Customer',
            'surname' => 'User',
            'email' => 'customer@jargonconsulting.com.au',
            'password' => bcrypt('password'),
            'dark_mode' => false,
        ]);
        $customer->assignRole('Customer');
    }
}
