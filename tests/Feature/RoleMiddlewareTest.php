<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        Route::middleware('role:manage users')->get('/admin-only', fn () => 'admin');
        Route::middleware('role:access customer area')->get('/customer-only', fn () => 'customer');
    }

    public function test_admin_can_access_admin_route(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage users');
        $this->actingAs($user);

        $this->get('/admin-only')->assertOk();
    }

    public function test_customer_cannot_access_admin_route(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('access customer area');
        $this->actingAs($user);

        $this->get('/admin-only')->assertForbidden();
    }

    public function test_guest_cannot_access_admin_route(): void
    {
        $this->get('/admin-only')->assertForbidden();
    }

    public function test_customer_can_access_customer_route(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('access customer area');
        $this->actingAs($user);

        $this->get('/customer-only')->assertOk();
    }

    public function test_admin_cannot_access_customer_route(): void
    {
        $user = User::factory()->create();
        $user->givePermissionTo('manage users');
        $this->actingAs($user);

        $this->get('/customer-only')->assertForbidden();
    }
}
