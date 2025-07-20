<?php

namespace Tests\Feature;

use App\Models\BackupSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackupSchedulingTest extends TestCase
{
    use RefreshDatabase;

    public function test_backup_settings_can_be_updated(): void
    {
        $setting = BackupSetting::create([
            'sftp_server' => 'old.example.com',
            'sftp_port' => 22,
            'sftp_username' => 'old',
            'sftp_password' => 'oldpass',
            'backup_retention' => 5,
            'backup_time' => '03:00:00',
        ]);

        $setting->update([
            'sftp_server' => 'new.example.com',
            'sftp_username' => 'new',
            'sftp_password' => 'newpass',
            'backup_retention' => 10,
            'backup_time' => '02:00:00',
        ]);

        $this->assertDatabaseHas('backup_settings', [
            'sftp_server' => 'new.example.com',
            'backup_retention' => 10,
            'backup_time' => '02:00:00',
        ]);
    }
}
