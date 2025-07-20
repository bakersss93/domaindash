<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMfaTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_enforce_and_reset_mfa(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'customer']);

        $this->actingAs($admin);

        $this->post(route('users.mfa.enforce', $user));
        $this->assertNotNull($user->fresh()->two_factor_secret);

        $this->post(route('users.mfa.reset', $user));
        $this->assertNull($user->fresh()->two_factor_secret);
    }
}

