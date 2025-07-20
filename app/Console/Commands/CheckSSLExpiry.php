<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SSLService;
use App\Services\NotificationService;
use Carbon\Carbon;

class CheckSSLExpiry extends Command
{
    protected $signature = 'ssl:check-expiry';
    protected $description = 'Check for SSL certificates nearing expiration';

    public function handle(NotificationService $service)
    {
        $threshold = Carbon::now()->addDays(30);
        $certs = SSLService::with('customer')
            ->where('expiration_date', '<=', $threshold)
            ->get();

        foreach ($certs as $cert) {
            if (!$cert->customer) {
                continue;
            }

            $service->notify(
                $cert->customer,
                'ssl_expiry',
                ['ssl_service_id' => $cert->id, 'expiration_date' => $cert->expiration_date],
                [
                    'domain_name' => $cert->certificate_name,
                    'expiration_date' => $cert->expiration_date->toDateString(),
                ]
            );
        }

        $this->info('SSL expiry check completed.');
    }
}
