<?php

namespace Tests\Feature;

use App\Models\ApiKey;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiKeyRestrictionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_allowed_ips_casts_to_array(): void
    {
        $apiKey = ApiKey::create([
            'key_name' => 'Test Key',
            'hashed_key' => hash('sha256', 'secret'),
            'permissions' => 'read-only',
            'allowed_ips' => '127.0.0.1',
            'rate_limit' => 10,
        ]);

        $apiKey->refresh();

        $this->assertSame('127.0.0.1', $apiKey->allowed_ips);
    }

    public function test_invalid_permission_value_throws_exception(): void
    {
        $this->expectException(QueryException::class);

        ApiKey::create([
            'key_name' => 'Bad',
            'hashed_key' => hash('sha256', 'secret'),
            'permissions' => 'invalid',
            'rate_limit' => 1,
        ]);
    }
}
