<?php

namespace Tests\Unit;

use App\Services\ITGlueClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class ITGlueClientTest extends TestCase
{
    public function test_create_or_update_configuration_sends_request(): void
    {
        Config::set('integrations.itglue.url', 'https://example.com');
        Config::set('integrations.itglue.api_key', 'token');

        Http::fake();

        $client = new ITGlueClient();
        $client->createOrUpdateConfiguration(['foo' => 'bar']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://example.com/configurations'
                && $request->method() === 'POST'
                && $request['foo'] === 'bar'
                && $request->hasHeader('x-api-key', 'token');
        });
    }
}
