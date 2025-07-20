<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ITGlueClient
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('itglue.api_url'), '/');
        $this->apiKey = config('itglue.api_key');
    }

    public function upsertConfiguration(array $config): array
    {
        $response = Http::withToken($this->apiKey)
            ->post($this->baseUrl . '/configurations', $config);

        if ($response->failed()) {
            throw new \Exception('ITGlue API request failed: ' . $response->body());
        }

        return $response->json();
    }
}
