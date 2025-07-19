<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HostingService;

class CheckDiskUsage extends Command
{
    protected $signature = 'disk:check';
    protected $description = 'Check disk usage and notify users if limits exceeded';

    public function handle()
    {
        $hostingServices = HostingService::all();
        foreach ($hostingServices as $service) {
            if ($service->disk_usage > $service->disk_space_threshold) {
                // Notify customer
            }
        }
    }
}
