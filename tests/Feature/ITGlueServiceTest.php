<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class ITGlueServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Config::set('itglue.api_url', 'https://itglue.local');
    }

    public function test_fetch_organizations_returns_fixture_data(): void
    {
        Http::fake([
            'https://itglue.local/api/organizations' => Http::response(json_decode(file_get_contents(base_path('tests/fixtures/itglue-orgs.json')), true)),
        ]);

        $response = Http::get(config('itglue.api_url') . '/api/organizations');

        $this->assertEquals('Test Org', $response->json('organizations.0.name'));
    }
}
