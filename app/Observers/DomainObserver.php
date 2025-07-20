<?php

namespace App\Observers;

use App\Models\Domain;
use App\Services\HaloPSAClient;
use App\Services\ITGlueClient;
use App\Events\AutomationWebhook;

class DomainObserver
{
    protected HaloPSAClient $halo;
    protected ITGlueClient $itglue;

    public function __construct(HaloPSAClient $halo, ITGlueClient $itglue)
    {
        $this->halo = $halo;
        $this->itglue = $itglue;
    }

    public function saved(Domain $domain): void
    {
        if ($domain->wasChanged('customer_id') && $domain->customer_id) {
            $payload = [
                'domain' => $domain->domain_name,
                'customer_id' => $domain->customer_id,
            ];
            $this->halo->createOrUpdateAsset($payload);
            $this->itglue->createOrUpdateConfiguration($payload);
            AutomationWebhook::dispatch('domain_linked', $payload);
        }

        if ($domain->wasChanged('renewal_date') && $domain->renewal_date) {
            $payload = [
                'domain' => $domain->domain_name,
                'expiry' => $domain->renewal_date->format('Y-m-d'),
            ];
            $this->halo->updateExpiry($domain->domain_name, $payload['expiry']);
            $this->itglue->updateExpiry($domain->domain_name, $payload['expiry']);
            AutomationWebhook::dispatch('domain_renewed', $payload);
        }
    }
}
