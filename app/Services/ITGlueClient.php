<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ITGlueClient
{
    private string $baseUrl;
    private ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('integrations.itglue.url'), '/');
        $this->apiKey = config('integrations.itglue.api_key');
    }

    public function createOrUpdateConfiguration(array $data)
    {
        return Http::withHeaders(['x-api-key' => $this->apiKey])
            ->post("{$this->baseUrl}/configurations", $data)
            ->json();
    }

    public function updateExpiry($configId, string $expiry)
    {
        return Http::withHeaders(['x-api-key' => $this->apiKey])
            ->patch("{$this->baseUrl}/configurations/{$configId}", ['expiry_date' => $expiry])
            ->json();
    }
}
