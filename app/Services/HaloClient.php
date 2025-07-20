<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class HaloClient
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('halo.api_url'), '/');
        $this->apiKey = config('halo.api_key');
    }

    public function upsertAsset(array $asset): array
    {
        $response = Http::withToken($this->apiKey)
            ->post($this->baseUrl . '/assets', $asset);

        if ($response->failed()) {
            throw new \Exception('HaloPSA API request failed: ' . $response->body());
        }

        return $response->json();
    }
}
