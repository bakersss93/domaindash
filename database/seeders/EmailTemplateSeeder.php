<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmailTemplateSeeder extends Seeder
{
    public function run()
    {
        EmailTemplate::create([
            'template_type' => 'domain_expiry',
            'subject' => 'Domain Expiry Notification',
            'body' => '<p>Dear {{ customer_name }},</p><p>Your domain {{ domain_name }} is set to expire on {{ renewal_date }}. Please renew it promptly.</p>',
        ]);

        EmailTemplate::create([
            'template_type' => 'ssl_expiry',
            'subject' => 'SSL Expiry Notification',
            'body' => '<p>Dear {{ customer_name }},</p><p>Your SSL certificate for {{ domain_name }} will expire on {{ expiration_date }}. Please renew it promptly.</p>',
        ]);

        EmailTemplate::create([
            'template_type' => 'disk_space_warning',
            'subject' => 'Disk Space Usage Alert',
            'body' => '<p>Dear {{ customer_name }},</p><p>Your hosting account is using {{ disk_usage }}% of your allotted space. Please free up space or upgrade your plan.</p>',
        ]);
    }
}
