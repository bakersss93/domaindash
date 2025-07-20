<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class HaloPsaClient
{
    private Client $client;
    private string $apiKey;

    public function __construct()
    {
        $baseUrl = rtrim(config('halo.base_url'), '/');
        $this->apiKey = config('halo.api_key');

        $this->client = new Client([
            'base_uri' => $baseUrl,
            'headers' => [
                'apikey' => $this->apiKey,
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function createTicket(array $data): array
    {
        try {
            $response = $this->client->post('/api/tickets', [
                'json' => $data,
            ]);

            return json_decode((string) $response->getBody(), true);
        } catch (GuzzleException $e) {
            throw new \Exception('HaloPSA API Error: ' . $e->getMessage());
        }
    }
}
