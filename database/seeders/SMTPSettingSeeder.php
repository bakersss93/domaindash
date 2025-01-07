<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SMTPSetting;

class SMTPSettingSeeder extends Seeder
{
    public function run()
    {
        SMTPSetting::create([
            'send_from_email' => 'noreply@jargonconsulting.com.au',
            'smtp_server' => 'smtp.jargonconsulting.com.au',
            'smtp_port' => 587,
            'smtp_username' => 'smtp_user',
            'smtp_password' => 'smtp_password',
        ]);
    }
}
