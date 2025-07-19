<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function bulkUpdateDomains()
    {
        $domainList = Domain::pluck('domain_name')->toArray();

        try {
            $synergy = app('synergy');
            $response = $synergy->bulkDomainInfo($domainList);

            // Process the response
            foreach ($response['domains'] as $domainData) {
                Domain::updateOrCreate(
                    ['domain_name' => $domainData['domainName']],
                    [
                        'customer_id' => null, // Initially unassigned
                        'auto_renew' => $domainData['autoRenew'] ?? null,
                        'renewal_date' => $domainData['renewalDate'] ?? null,
                        'transfer_status' => $domainData['transferStatus'] ?? null,
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
