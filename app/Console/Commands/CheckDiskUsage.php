<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HostingService;
use App\Services\NotificationService;

class CheckDiskUsage extends Command
{
    protected $signature = 'disk:check';
    protected $description = 'Check disk usage and notify users if limits exceeded';

    public function handle(NotificationService $service)
    {
        $hostingServices = HostingService::with('customer')->get();
        foreach ($hostingServices as $hs) {
            if ($hs->customer && $hs->disk_usage > $hs->disk_space_threshold) {
                $service->notify(
                    $hs->customer,
                    'disk_space_warning',
                    ['hosting_service_id' => $hs->id, 'disk_usage' => $hs->disk_usage],
                    [
                        'disk_usage' => $hs->disk_usage,
                    ]
                );
            }
        }

        $this->info('Disk usage check completed.');
    }
}
