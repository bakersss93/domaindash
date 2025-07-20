<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class HaloPsaServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('halo.api_url', 'https://halo.local');
    }

    public function test_fetch_tickets_returns_fixture_data(): void
    {
        Http::fake([
            'https://halo.local/api/tickets' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/halo-tickets.json')), true)),
        ]);

        $response = Http::get(config('halo.api_url') . '/api/tickets');

        $this->assertEquals(1, $response->json('tickets.0.id'));
    }
}
