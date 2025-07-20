<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;
use App\Services\SynergyClient;

class DomainController extends Controller
{
    private SynergyClient $synergy;

    public function __construct(SynergyClient $synergy)
    {
        $this->synergy = $synergy;
    }

    public function bulkUpdateDomains()
    {
        try {
            $domainList = Domain::pluck('domain_name')->toArray();

            $response = $this->synergy->bulkDomainInfo([
                'domainList' => $domainList,
            ]);

            if (($response['status'] ?? '') !== 'OK') {
                throw new \Exception($response['errorMessage'] ?? 'API error');
            }

            foreach ($response['domainList'] as $domainData) {
                if (($domainData['status'] ?? '') !== 'OK') {
                    continue;
                }
                Domain::updateOrCreate(
                    ['domain_name' => $domainData['domainName']],
                    [
                        'customer_id' => null,
                        'auto_renew' => $domainData['autoRenew'] ?? null,
                        'renewal_date' => $domainData['domain_expiry'] ?? null,
                        'transfer_status' => $domainData['transfer_status'] ?? null,
                    ]
                );
            }

            return redirect()->route('admin.domains.index')
                             ->with('success', 'Domains updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update domains: ' . $e->getMessage()]);
        }
    }

    public function checkAvailability(Request $request)
    {
        $request->validate(['domain' => 'required|string']);

        try {
            $result = $this->synergy->checkDomainAvailability($request->input('domain'));
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function initiateTransfer(Domain $domain)
    {
        try {
            $this->synergy->initiateDomainTransfer(['domainName' => $domain->domain_name]);
            return back()->with('success', 'Transfer initiated');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function renew(Domain $domain)
    {
        try {
            $this->synergy->renewDomain($domain->domain_name);
            return back()->with('success', 'Domain renewed');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
