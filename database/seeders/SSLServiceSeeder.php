<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SSLService;

class SSLServiceSeeder extends Seeder
{
    public function run()
    {
        SSLService::create([
            'certificate_name' => 'SSL for example.com',
            'client_id' => 1,
            'expiration_date' => now()->addMonths(11),
            'details' => json_encode(['provider' => 'Comodo', 'type' => 'DV']),
        ]);

        SSLService::create([
            'certificate_name' => 'SSL for example.org',
            'client_id' => 1,
            'expiration_date' => now()->addMonths(6),
            'details' => json_encode(['provider' => 'GoDaddy', 'type' => 'EV']),
        ]);
    }
}
