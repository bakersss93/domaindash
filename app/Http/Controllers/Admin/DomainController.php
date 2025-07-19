<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use SoapClient;

class DomainController extends Controller
{
    public function bulkUpdateDomains()
    {
        // Synergy Wholesale API credentials
        $apiEndpoint = config('synergy.api_url');
        $resellerId = config('synergy.reseller_id');
        $apiKey = config('synergy.api_key');

        try {
            // SOAP Client setup
            $client = new SoapClient($apiEndpoint, [
                'trace' => true,
                'exceptions' => true,
            ]);

            // API Request
            $response = $client->bulkDomainInfo([
                'resellerId' => $resellerId,
                'apiKey' => $apiKey,
            ]);

            // Process the response
            foreach ($response->domains as $domainData) {
                Domain::updateOrCreate(
                    ['domain_name' => $domainData->domainName],
                    [
                        'customer_id' => null, // Initially unassigned
                        'auto_renew' => $domainData->autoRenew,
                        'renewal_date' => $domainData->renewalDate,
                        'transfer_status' => $domainData->transferStatus,
                    ]
                );
            }

            return redirect()->route('admin.domains.index')
                             ->with('success', 'Domains updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update domains: ' . $e->getMessage()]);
        }
    }
}
