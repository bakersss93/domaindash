<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'last_sync_at',
        'last_backup_at',
    ];

    protected $casts = [
        'last_sync_at' => 'datetime',
        'last_backup_at' => 'datetime',
    ];
}
