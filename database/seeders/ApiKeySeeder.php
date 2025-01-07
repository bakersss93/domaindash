<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApiKey;

class ApiKeySeeder extends Seeder
{
    public function run()
    {
        ApiKey::create([
            'key_name' => 'Primary API Key',
            'description' => 'Main API key for integration',
            'hashed_key' => hash('sha256', 'primary-api-key'),
            'permissions' => 'read-only',
            'allowed_ips' => '192.168.1.1,192.168.1.2',
            'rate_limit' => 1000,
            'expires_at' => now()->addYear(),
        ]);
    }
}
