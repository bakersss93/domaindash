<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SynergyWholesaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton('synergy', function () {
            return new class {
                private $client;
                private $resellerId;
                private $apiKey;

                public function __construct()
                {
                    $this->resellerId = config('synergy.reseller_id');
                    $this->apiKey = config('synergy.api_key');

                    // Initialize the SOAP client
                    $this->client = new \SoapClient(config('synergy.api_url'), [
                        'trace' => 1,
                        'exceptions' => true,
                        'cache_wsdl' => WSDL_CACHE_NONE,
                    ]);
                }

                /**
                 * Execute a SOAP request with authentication.
                 */
                private function request($method, $params = [])
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

                // Domain Management
                public function checkDomainAvailability($domain)
                {
                    return $this->request('checkDomain', ['domainName' => $domain]);
                }

                public function retrieveBulkDomainInformation()
                {
                    return $this->request('bulkDomainInfo');
                }

                public function transferDomain($domain, $authCode)
                {
                    return $this->request('transferDomain', [
                        'domainName' => $domain,
                        'authCode' => $authCode,
                    ]);
                }

                public function renewDomain($domain)
                {
                    return $this->request('renewDomain', ['domainName' => $domain]);
                }

                // DNS Management
                public function retrieveDNSRecords($domain)
                {
                    return $this->request('listDNSZone', ['domainName' => $domain]);
                }

                public function createDNSRecord($domain, $type, $name, $value, $ttl = 3600)
                {
                    return $this->request('AddDNSRecord', [
                        'domainName' => $domain,
                        'type' => $type,
                        'name' => $name,
                        'value' => $value,
                        'ttl' => $ttl,
                    ]);
                }

                public function updateDNSRecord($domain, $recordId, $type, $name, $value, $ttl = 3600)
                {
                    return $this->request('UpdateDNSRecord', [
                        'domainName' => $domain,
                        'recordID' => $recordId,
                        'type' => $type,
                        'name' => $name,
                        'value' => $value,
                        'ttl' => $ttl,
                    ]);
                }

                public function deleteDNSRecord($domain, $recordId)
                {
                    return $this->request('DeleteDNSRecord', [
                        'domainName' => $domain,
                        'recordID' => $recordId,
                    ]);
                }

                public function retrieveDNSZone($domain)
                {
                    return $this->request('listDNSZone', ['domainName' => $domain]);
                }

                public function delegateDNSZone($domain, $nameservers)
                {
                    return $this->request('UpdateNameServers', [
                        'domainName' => $domain,
                        'nameServers' => $nameservers,
                    ]);
                }


                // Hosting Services
                public function retrieveHostingServices($domain)
                {
                    return $this->request('hostingGetService', ['domainName' => $domain]);
                }

                public function loginToCpanel($domain)
                {
                    return $this->request('hostingGetLogin', ['domainName' => $domain]);
                }

                // SSL Services
                public function retrieveSSLCertificates()
                {
                    return $this->request('SSL_listAllCerts');
                }

                public function renewSSLCertificate($certificateId)
                {
                    return $this->request('SSL_renewSSLCertificate', ['certificateID' => $certificateId]);
                }

                public function purchaseSSLCertificate($params)
                {
                    return $this->request('SSL_purchaseSSLCertificate', $params);
                }

                // Account Management
                public function retrieveResellerBalance()
                {
                    return $this->request('balanceQuery');
                }
            };
        });
    }
}
