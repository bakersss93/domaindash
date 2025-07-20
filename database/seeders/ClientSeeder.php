<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $client = Client::create([
            'business_name' => 'Example Pty Ltd',
            'abn' => '123456789',
            'halo_reference' => 'HALO123',
            'itglue_org_id' => 1,
            'active' => true,
        ]);

        $customer = User::where('role', 'customer')->first();
        if ($customer) {
            $client->users()->attach($customer->id);
        }
    }
}
