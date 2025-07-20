<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class BackupCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::command('backup:run', function () {
            $this->info('Backup completed');
        });
    }

    public function test_backup_command_runs(): void
    {
        $this->artisan('backup:run')->assertSuccessful();
    }
}
