<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecordSystemMetrics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:record-metrics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Record storage, CPU, memory and DB metrics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $storageTotal = disk_total_space('/') ?: 0;
        $storageFree = disk_free_space('/') ?: 0;
        $storageUsed = $storageTotal > 0 ? (int) round(100 * ($storageTotal - $storageFree) / $storageTotal) : 0;

        \App\Models\SystemMetric::create([
            'metric_type' => 'storage',
            'value' => $storageUsed,
            'recorded_at' => now(),
        ]);

        $load = sys_getloadavg();
        $cpu = isset($load[0]) ? (int) round($load[0] * 100) : 0;

        \App\Models\SystemMetric::create([
            'metric_type' => 'cpu',
            'value' => $cpu,
            'recorded_at' => now(),
        ]);

        $memInfo = file_get_contents('/proc/meminfo');
        preg_match('/MemTotal:\s+(\d+)/', $memInfo, $totalMatch);
        preg_match('/MemAvailable:\s+(\d+)/', $memInfo, $availMatch);
        $memory = 0;
        if ($totalMatch && $availMatch && $totalMatch[1] > 0) {
            $memory = (int) round(100 * (($totalMatch[1] - $availMatch[1]) / $totalMatch[1]));
        }

        \App\Models\SystemMetric::create([
            'metric_type' => 'memory',
            'value' => $memory,
            'recorded_at' => now(),
        ]);

        $size = \DB::selectOne("SELECT SUM(data_length + index_length) AS size FROM information_schema.tables WHERE table_schema = DATABASE()");
        $dbSize = isset($size->size) ? (int) round($size->size / 1024 / 1024) : 0;

        \App\Models\SystemMetric::create([
            'metric_type' => 'database',
            'value' => $dbSize,
            'recorded_at' => now(),
        ]);

        return Command::SUCCESS;
    }
}
