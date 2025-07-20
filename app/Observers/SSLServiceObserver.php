<?php

namespace App\Observers;

use App\Models\SSLService;
use App\Services\HaloPSAClient;
use App\Services\ITGlueClient;
use App\Events\AutomationWebhook;

class SSLServiceObserver
{
    protected HaloPSAClient $halo;
    protected ITGlueClient $itglue;

    public function __construct(HaloPSAClient $halo, ITGlueClient $itglue)
    {
        $this->halo = $halo;
        $this->itglue = $itglue;
    }

    public function saved(SSLService $service): void
    {
        if ($service->wasChanged('customer_id') && $service->customer_id) {
            $payload = [
                'certificate' => $service->certificate_name,
                'customer_id' => $service->customer_id,
            ];
            $this->halo->createOrUpdateAsset($payload);
            $this->itglue->createOrUpdateConfiguration($payload);
            AutomationWebhook::dispatch('ssl_linked', $payload);
        }

        if ($service->wasChanged('expiration_date') && $service->expiration_date) {
            $payload = [
                'certificate' => $service->certificate_name,
                'expiry' => $service->expiration_date->format('Y-m-d'),
            ];
            $this->halo->updateExpiry($service->certificate_name, $payload['expiry']);
            $this->itglue->updateExpiry($service->certificate_name, $payload['expiry']);
            AutomationWebhook::dispatch('ssl_renewed', $payload);
        }
    }
}
