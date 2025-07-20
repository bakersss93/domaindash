<?php

namespace App\Services;

class SynergyClient
{
    private \SoapClient $client;
    private string $resellerId;
    private string $apiKey;

    public function __construct()
    {
        $this->resellerId = config('synergy.reseller_id');
        $this->apiKey = config('synergy.api_key');

        $this->client = new \SoapClient(config('synergy.api_url'), [
            'trace' => 1,
            'exceptions' => true,
            'cache_wsdl' => WSDL_CACHE_NONE,
        ]);
    }

    private function request(string $method, array $params = [])
    {
        $params = array_merge([
            'resellerID' => $this->resellerId,
            'apiKey' => $this->apiKey,
        ], $params);

        try {
            $response = $this->client->__soapCall($method, [$params]);
            return json_decode(json_encode($response), true);
        } catch (\SoapFault $e) {
            throw new \Exception("SOAP API Error: {$e->getMessage()}");
        }
    }

    public function bulkDomainInfo(array $params)
    {
        return $this->request('BulkDomainInfo', $params);
    }

    public function checkDomainAvailability(string $domain)
    {
        return $this->request('CheckDomain', ['domainName' => $domain]);
    }

    public function initiateDomainTransfer(array $params)
    {
        return $this->request('InitiateDomainTransfer', $params);
    }

    public function renewDomain(string $domain, int $years = 1)
    {
        return $this->request('RenewDomain', ['domainName' => $domain, 'years' => $years]);
    }

    public function __call(string $name, array $arguments)
    {
        $params = $arguments[0] ?? [];
        return $this->request($name, $params);
    }
}
