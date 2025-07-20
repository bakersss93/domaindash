<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RecordBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:record-backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Record the time of last backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \App\Models\SystemStatus::first()->update(['last_backup_at' => now()]);
        return Command::SUCCESS;
    }
}
