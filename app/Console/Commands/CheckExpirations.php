<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use App\Models\SSLService;
use App\Models\EmailTemplate;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckExpirations extends Command
{
    protected $signature = 'check:expirations';
    protected $description = 'Notify customers about upcoming domain and SSL expirations';

    public function handle()
    {
        $domainTemplate = EmailTemplate::where('template_type', 'domain_expiry')->first();
        $sslTemplate = EmailTemplate::where('template_type', 'ssl_expiry')->first();

        $soon = Carbon::now()->addDays(30);

        $domains = Domain::with('customer')->where('renewal_date', '<=', $soon)->get();
        foreach ($domains as $domain) {
            if ($domain->customer && $domainTemplate) {
                $body = str_replace([
                    '{{ customer_name }}',
                    '{{ domain_name }}',
                    '{{ renewal_date }}'
                ], [
                    $domain->customer->first_name,
                    $domain->domain_name,
                    $domain->renewal_date->toDateString()
                ], $domainTemplate->body);

                Mail::raw(strip_tags($body), function ($message) use ($domainTemplate, $domain) {
                    $message->to($domain->customer->email)
                            ->subject($domainTemplate->subject);
                });

                Notification::create([
                    'user_id' => $domain->customer->id,
                    'notification_type' => 'domain_expiry',
                    'details' => [
                        'domain_id' => $domain->id,
                        'renewal_date' => $domain->renewal_date,
                    ],
                    'is_read' => false,
                ]);
            }
        }

        $sslServices = SSLService::with('customer')->where('expiration_date', '<=', $soon)->get();
        foreach ($sslServices as $ssl) {
            if ($ssl->customer && $sslTemplate) {
                $body = str_replace([
                    '{{ customer_name }}',
                    '{{ domain_name }}',
                    '{{ expiration_date }}'
                ], [
                    $ssl->customer->first_name,
                    $ssl->certificate_name,
                    $ssl->expiration_date->toDateString()
                ], $sslTemplate->body);

                Mail::raw(strip_tags($body), function ($message) use ($sslTemplate, $ssl) {
                    $message->to($ssl->customer->email)
                            ->subject($sslTemplate->subject);
                });

                Notification::create([
                    'user_id' => $ssl->customer->id,
                    'notification_type' => 'ssl_expiry',
                    'details' => [
                        'ssl_service_id' => $ssl->id,
                        'expiration_date' => $ssl->expiration_date,
                    ],
                    'is_read' => false,
                ]);
            }
        }
    }
}
