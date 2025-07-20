<?php

return [
    'halopsa' => [
        'url' => env('HALOPSA_URL', 'https://api.halopsa.com/v1'),
        'api_key' => env('HALOPSA_API_KEY'),
    ],
    'itglue' => [
        'url' => env('ITGLUE_URL', 'https://api.itglue.com'),
        'api_key' => env('ITGLUE_API_KEY'),
    ],
    'webhook_url' => env('AUTOMATION_WEBHOOK_URL'),
];
