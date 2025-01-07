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
            'customer_id' => 2,
            'auto_renew' => true,
            'renewal_date' => now()->addYear(),
        ]);

        Domain::create([
            'domain_name' => 'example.org',
            'customer_id' => 2,
            'auto_renew' => false,
            'renewal_date' => now()->addMonths(6),
        ]);
    }
}
