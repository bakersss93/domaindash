<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_domain_belongs_to_customer(): void
    {
        User::unguard();
        $user = User::create([
            'first_name' => 'Test',
            'surname' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('secret'),
            'role' => 'customer',
            'dark_mode' => false,
        ]);

        $domain = Domain::create([
            'domain_name' => 'example.com',
            'customer_id' => $user->id,
        ]);

        $this->assertTrue($domain->customer->is($user));
    }
}
