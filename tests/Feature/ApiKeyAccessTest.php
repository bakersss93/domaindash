<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiKeyAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        ApiKey::factory()->create([
            'id' => 1,
            'hashed_key' => hash('sha256', 'test-key'),
            'permissions' => 'read-only',
            'rate_limit' => 5,
            'allowed_ips' => null,
        ]);
    }

    public function test_request_without_key_is_rejected(): void
    {
        $this->getJson('/api/customers')->assertStatus(401);
    }

    public function test_valid_key_allows_access_and_logs_request(): void
    {
        $this->getJson('/api/customers', ['X-Api-Key' => 'test-key'])->assertOk();
        $this->assertDatabaseCount('access_logs', 1);
    }
}
