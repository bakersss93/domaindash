<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HaloPSAClient
{
    private string $baseUrl;
    private ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('integrations.halopsa.url'), '/');
        $this->apiKey = config('integrations.halopsa.api_key');
    }

    public function createOrUpdateAsset(array $data)
    {
        return Http::withHeaders(['Authorization' => $this->apiKey])
            ->post("{$this->baseUrl}/assets", $data)
            ->json();
    }

    public function updateExpiry($assetId, string $expiry)
    {
        return Http::withHeaders(['Authorization' => $this->apiKey])
            ->patch("{$this->baseUrl}/assets/{$assetId}", ['expiry' => $expiry])
            ->json();
    }
}
