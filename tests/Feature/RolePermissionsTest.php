<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_api_keys_index(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user);

        $this->get('/api-keys')->assertOk();
    }

    public function test_customer_cannot_access_api_keys_index(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        $this->actingAs($user);

        $this->get('/api-keys')->assertForbidden();
    }

    public function test_guest_redirected_from_api_keys_index(): void
    {
        $this->get('/api-keys')->assertRedirect('/login');
    }
}
