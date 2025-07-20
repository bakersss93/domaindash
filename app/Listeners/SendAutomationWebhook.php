<?php

namespace App\Listeners;

use App\Events\AutomationWebhook;
use Illuminate\Support\Facades\Http;

class SendAutomationWebhook
{
    public function handle(AutomationWebhook $event): void
    {
        $url = config('integrations.webhook_url');
        if (!$url) {
            return;
        }
        Http::post($url, [
            'type' => $event->type,
            'payload' => $event->payload,
        ]);
    }
}
