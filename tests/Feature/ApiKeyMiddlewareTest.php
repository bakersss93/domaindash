<?php

namespace Tests\Feature;

use App\Http\Middleware\ApiKeyMiddleware;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ApiKeyMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('api_key')->get('/api-test', fn () => 'ok');
    }

    public function test_valid_key_allows_access(): void
    {
        $apiKey = ApiKey::factory()->create();

        $response = $this->withHeaders(['Authorization' => 'Bearer testtoken'])
            ->get('/api-test');

        $response->assertOk();
    }

    public function test_invalid_key_rejected(): void
    {
        $response = $this->withHeaders(['Authorization' => 'Bearer wrong'])
            ->get('/api-test');

        $response->assertUnauthorized();
    }
}
