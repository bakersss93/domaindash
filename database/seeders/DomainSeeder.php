<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Domain;

class DomainSeeder extends Seeder
{
    public function run()
    {
        Domain::create([
            'domain_name' => 'example.com',
            'client_id' => 1,
            'auto_renew' => true,
            'renewal_date' => now()->addYear(),
        ]);

        Domain::create([
            'domain_name' => 'example.org',
            'client_id' => 1,
            'auto_renew' => false,
            'renewal_date' => now()->addMonths(6),
        ]);
    }
}
