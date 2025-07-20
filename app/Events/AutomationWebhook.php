<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class AutomationWebhook
{
    use Dispatchable;

    public string $type;
    public array $payload;

    public function __construct(string $type, array $payload)
    {
        $this->type = $type;
        $this->payload = $payload;
    }
}
