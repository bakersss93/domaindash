<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('role:admin')->get('/admin-only', fn () => 'admin');
        Route::middleware('role:customer')->get('/customer-only', fn () => 'customer');
        Route::middleware('role:technician')->get('/tech-only', fn () => 'tech');
    }

    public function test_admin_can_access_admin_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'admin']);
        $this->actingAs($user);

        $this->get('/admin-only')->assertOk();
    }

    public function test_customer_cannot_access_admin_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'customer']);
        $this->actingAs($user);

        $this->get('/admin-only')->assertForbidden();
    }

    public function test_guest_cannot_access_admin_route(): void
    {
        $this->get('/admin-only')->assertForbidden();
    }

    public function test_customer_can_access_customer_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'customer']);
        $this->actingAs($user);

        $this->get('/customer-only')->assertOk();
    }

    public function test_admin_cannot_access_customer_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'admin']);
        $this->actingAs($user);

        $this->get('/customer-only')->assertForbidden();
    }

    public function test_technician_can_access_technician_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'technician']);
        $this->actingAs($user);

        $this->get('/tech-only')->assertOk();
    }

    public function test_customer_cannot_access_technician_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'customer']);
        $this->actingAs($user);

        $this->get('/tech-only')->assertForbidden();
    }

    public function test_admin_cannot_access_technician_route(): void
    {
        $user = User::factory()->make(['id' => 1, 'role' => 'admin']);
        $this->actingAs($user);

        $this->get('/tech-only')->assertForbidden();
    }
}
