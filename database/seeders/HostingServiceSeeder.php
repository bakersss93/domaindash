<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HostingService;

class HostingServiceSeeder extends Seeder
{
    public function run()
    {
        HostingService::create([
            'service_name' => 'Basic Hosting',
            'client_id' => 1,
            'disk_usage' => 10,
            'database_usage' => 2,
            'disk_space_threshold' => 80,
            'hosting_plan' => 'Starter Plan',
        ]);

        HostingService::create([
            'service_name' => 'Premium Hosting',
            'client_id' => 1,
            'disk_usage' => 50,
            'database_usage' => 10,
            'disk_space_threshold' => 80,
            'hosting_plan' => 'Premium Plan',
        ]);
    }
}
