<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\HostingService;
use App\Models\EmailTemplate;
use App\Models\Notification;
use App\Models\DiskSetting;
use Illuminate\Support\Facades\Mail;

class CheckDiskUsage extends Command
{
    protected $signature = 'disk:check';
    protected $description = 'Check disk usage and notify users if limits exceeded';

    public function handle()
    {
        $hostingServices = HostingService::all();
        foreach ($hostingServices as $service) {
            $threshold = $service->disk_space_threshold;
            if (!$threshold) {
                $threshold = optional(DiskSetting::first())->warning_threshold ?? 80;
            }

            if ($service->disk_usage > $threshold && $service->customer) {
                $template = EmailTemplate::where('template_type', 'disk_space_warning')->first();
                if ($template) {
                    $body = str_replace([
                        '{{ customer_name }}',
                        '{{ disk_usage }}'
                    ], [
                        $service->customer->first_name,
                        $service->disk_usage
                    ], $template->body);

                    Mail::raw(strip_tags($body), function ($message) use ($service, $template) {
                        $message->to($service->customer->email)
                                ->subject($template->subject);
                    });
                }

                Notification::create([
                    'user_id' => $service->customer->id,
                    'notification_type' => 'disk_space_warning',
                    'details' => [
                        'disk_usage' => $service->disk_usage,
                        'threshold' => $threshold,
                        'service_id' => $service->id,
                    ],
                    'is_read' => false,
                ]);
            }
        }
    }
}
