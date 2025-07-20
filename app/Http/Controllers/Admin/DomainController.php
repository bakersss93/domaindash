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

            \App\Models\SystemStatus::first()->update(['last_sync_at' => now()]);

            return redirect()->route('admin.domains.index')
                             ->with('success', 'Domains updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update domains: ' . $e->getMessage()]);
        }
    }
}
