<?php

namespace Tests\Unit;

use App\Services\HaloPSAClient;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Facades\Config;

class HaloPSAClientTest extends TestCase
{
    public function test_create_or_update_asset_sends_request(): void
    {
        Config::set('integrations.halopsa.url', 'https://example.com');
        Config::set('integrations.halopsa.api_key', 'token');

        Http::fake();

        $client = new HaloPSAClient();
        $client->createOrUpdateAsset(['foo' => 'bar']);

        Http::assertSent(function ($request) {
            return $request->url() === 'https://example.com/assets'
                && $request->method() === 'POST'
                && $request['foo'] === 'bar'
                && $request->hasHeader('Authorization', 'token');
        });
    }
}
