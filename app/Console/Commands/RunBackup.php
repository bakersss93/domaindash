<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use App\Models\BackupSetting;
use App\Models\Backup;
use ZipArchive;

class RunBackup extends Command
{
    protected $signature = 'backup:run';
    protected $description = 'Dump database, zip it and upload via SFTP';

    public function handle()
    {
        $settings = BackupSetting::first();
        if (! $settings) {
            $this->error('Backup settings not configured.');
            return Command::FAILURE;
        }

        $connection = Config::get('database.default');
        $db = Config::get("database.connections.$connection");

        $timestamp = now()->format('Ymd_His');
        $fileName = "backup_{$timestamp}.sql";
        $backupDir = storage_path('app/backups');
        if (! is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
        $filePath = $backupDir . '/' . $fileName;

        $dumpCmd = sprintf(
            'mysqldump -u%s -p%s -h%s %s > %s',
            escapeshellarg($db['username']),
            escapeshellarg($db['password']),
            escapeshellarg($db['host']),
            escapeshellarg($db['database']),
            escapeshellarg($filePath)
        );
        $process = Process::fromShellCommandline($dumpCmd);
        $process->setTimeout(null);
        $process->run();
        if (! $process->isSuccessful()) {
            $this->error($process->getErrorOutput());
            return Command::FAILURE;
        }

        $zipPath = $filePath . '.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            $zip->addFile($filePath, $fileName);
            $zip->close();
        }
        unlink($filePath);

        $disk = Storage::build([
            'driver' => 'sftp',
            'host' => $settings->sftp_server,
            'port' => $settings->sftp_port,
            'username' => $settings->sftp_username,
            'password' => $settings->sftp_password,
        ]);

        $remote = basename($zipPath);
        $disk->put($remote, fopen($zipPath, 'r'));

        Backup::create([
            'file_name' => $remote,
            'uploaded_at' => now(),
        ]);

        $this->cleanOldBackups($disk, $settings->backup_retention);

        unlink($zipPath);

        $this->info('Backup completed.');
        return Command::SUCCESS;
    }

    protected function cleanOldBackups($disk, $days)
    {
        $expired = Backup::where('created_at', '<', now()->subDays($days))->get();
        foreach ($expired as $backup) {
            $disk->delete($backup->file_name);
            $localPath = storage_path('app/backups/'.$backup->file_name);
            if (file_exists($localPath)) {
                unlink($localPath);
            }
            $backup->delete();
        }
    }
}
