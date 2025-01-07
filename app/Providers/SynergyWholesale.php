<?php

namespace App\Services;

use SoapClient;

class SynergyWholesaleApi
{
    protected $client;

    public function __construct()
    {
        $this->client = new SoapClient(config('services.synergy.endpoint'), [
            'trace' => true,
            'exceptions' => true,
        ]);
    }

    public function bulkDomainInfo()
    {
        return $this->client->bulkDomainInfo([
            'resellerId' => config('services.synergy.reseller_id'),
            'apiKey' => config('services.synergy.api_key'),
        ]);
    }

    public function checkDomainAvailability($domain)
    {
        return $this->client->domainAvailability([
            'resellerId' => config('services.synergy.reseller_id'),
            'apiKey' => config('services.synergy.api_key'),
            'domainName' => $domain,
        ]);
    }

    public function initiateTransfer($domain, $authCode)
    {
        return $this->client->transferDomain([
            'resellerId' => config('services.synergy.reseller_id'),
            'apiKey' => config('services.synergy.api_key'),
            'domainName' => $domain,
            'authCode' => $authCode,
        ]);
    }
}

