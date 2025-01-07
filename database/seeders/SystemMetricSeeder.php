<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemMetric;

class SystemMetricSeeder extends Seeder
{
    public function run()
    {
        SystemMetric::create([
            'metric_type' => 'storage',
            'value' => 200,
            'recorded_at' => now(),
        ]);

        SystemMetric::create([
            'metric_type' => 'cpu',
            'value' => 30,
            'recorded_at' => now(),
        ]);
    }
}
