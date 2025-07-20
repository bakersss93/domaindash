<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncSynergyData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synergy:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise domain, hosting and SSL data from Synergy Wholesale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $synergy = app('synergy');

        $domainList = \App\Models\Domain::pluck('domain_name')->toArray();
        $response = $synergy->bulkDomainInfo(['domainList' => $domainList]);

        if (($response['status'] ?? '') === 'OK') {
            foreach ($response['domainList'] as $domainData) {
                if (($domainData['status'] ?? '') !== 'OK') {
                    continue;
                }

                \App\Models\Domain::updateOrCreate(
                    ['domain_name' => $domainData['domainName']],
                    [
                        'auto_renew' => $domainData['autoRenew'] ?? null,
                        'renewal_date' => $domainData['domain_expiry'] ?? null,
                        'transfer_status' => $domainData['transfer_status'] ?? null,
                    ]
                );
            }
        }

        $this->info('Synergy data synced');
    }
}
