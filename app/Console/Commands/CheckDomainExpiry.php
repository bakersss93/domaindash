<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Services\NotificationService;
use Carbon\Carbon;

class CheckDomainExpiry extends Command
{
    protected $signature = 'domains:check-expiry';
    protected $description = 'Check for domains nearing expiration';

    public function handle(NotificationService $service)
    {
        $threshold = Carbon::now()->addDays(30);
        $domains = Domain::with('customer')
            ->whereNotNull('renewal_date')
            ->where('renewal_date', '<=', $threshold)
            ->get();

        foreach ($domains as $domain) {
            if (!$domain->customer) {
                continue;
            }

            $service->notify(
                $domain->customer,
                'domain_expiry',
                ['domain_id' => $domain->id, 'renewal_date' => $domain->renewal_date],
                [
                    'domain_name' => $domain->domain_name,
                    'renewal_date' => $domain->renewal_date->toDateString(),
                ]
            );
        }

        $this->info('Domain expiry check completed.');
    }
}
