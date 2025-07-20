<?php

namespace App\Observers;

use App\Models\HostingService;
use App\Services\HaloPSAClient;
use App\Services\ITGlueClient;
use App\Events\AutomationWebhook;

class HostingServiceObserver
{
    protected HaloPSAClient $halo;
    protected ITGlueClient $itglue;

    public function __construct(HaloPSAClient $halo, ITGlueClient $itglue)
    {
        $this->halo = $halo;
        $this->itglue = $itglue;
    }

    public function saved(HostingService $service): void
    {
        if ($service->wasChanged('customer_id') && $service->customer_id) {
            $payload = [
                'service' => $service->service_name,
                'customer_id' => $service->customer_id,
            ];
            $this->halo->createOrUpdateAsset($payload);
            $this->itglue->createOrUpdateConfiguration($payload);
            AutomationWebhook::dispatch('hosting_linked', $payload);
        }
    }
}
