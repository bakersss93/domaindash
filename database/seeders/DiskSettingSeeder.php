<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiskSetting;

class DiskSettingSeeder extends Seeder
{
    public function run()
    {
        DiskSetting::create([
            'warning_threshold' => 80,
        ]);
    }
}
