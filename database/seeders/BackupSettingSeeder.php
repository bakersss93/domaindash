<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BackupSetting;

class BackupSettingSeeder extends Seeder
{
    public function run()
    {
        BackupSetting::create([
            'sftp_server' => 'sftp.jargonconsulting.com.au',
            'sftp_port' => 22,
            'sftp_username' => 'backup_user',
            'sftp_password' => 'backup_password',
            'backup_retention' => 5,
            'backup_time' => '03:00:00',
        ]);
    }
}
