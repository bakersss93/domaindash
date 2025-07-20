<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\BackupSetting;
use Carbon\Carbon;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Export the MySQL database, zip it, and upload via SFTP';

    public function handle(): int
    {
        $settings = BackupSetting::first();
        if (! $settings) {
            $this->error('Backup settings not configured.');
            return Command::FAILURE;
        }

        $filename = 'backup-' . now()->format('Y-m-d_His') . '.sql';
        $localPath = storage_path('app/' . $filename);

        if (! $this->dumpDatabase($localPath)) {
            $this->error('Failed to dump database');
            return Command::FAILURE;
        }

        $zipPath = $this->zipFile($localPath);

        $disk = Storage::build([
            'driver' => 'sftp',
            'host' => $settings->sftp_server,
            'port' => $settings->sftp_port,
            'username' => $settings->sftp_username,
            'password' => $settings->sftp_password,
        ]);

        $disk->put(basename($zipPath), fopen($zipPath, 'r'));

        unlink($localPath);
        unlink($zipPath);

        $this->enforceRetention($disk, $settings->backup_retention);

        $this->info('Backup completed successfully.');
        return Command::SUCCESS;
    }

    protected function dumpDatabase(string $path): bool
    {
        $config = config('database.connections.mysql');
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s --port=%s %s > %s',
            escapeshellarg($config['username']),
            escapeshellarg($config['password']),
            escapeshellarg($config['host']),
            escapeshellarg($config['port']),
            escapeshellarg($config['database']),
            escapeshellarg($path)
        );

        return 0 === $this->execCommand($command);
    }

    protected function zipFile(string $path): string
    {
        $zipPath = $path . '.zip';
        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $zip->addFile($path, basename($path));
        $zip->close();
        return $zipPath;
    }

    protected function enforceRetention($disk, int $days): void
    {
        foreach ($disk->files() as $file) {
            $time = $disk->lastModified($file);
            if ($time && Carbon::createFromTimestamp($time)->lt(now()->subDays($days))) {
                $disk->delete($file);
            }
        }
    }

    protected function execCommand(string $command): int
    {
        return tap(proc_open($command, [1 => ['pipe','w'], 2 => ['pipe','w']], $pipes), function ($process) use (&$status) {
            $status = proc_close($process);
        }) && is_int($status) ? $status : 1;
    }
}
