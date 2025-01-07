<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        Notification::create([
            'user_id' => 2,
            'notification_type' => 'disk_space_warning',
            'details' => json_encode(['disk_usage' => 85, 'threshold' => 80]),
            'is_read' => false,
        ]);
    }
}
