<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'sftp_server',
        'sftp_port',
        'sftp_username',
        'sftp_password',
        'backup_retention',
        'backup_time',
    ];
}
