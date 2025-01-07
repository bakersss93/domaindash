<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'key_name',
        'description',
        'hashed_key',
        'permissions',
        'allowed_ips',
        'rate_limit',
        'access_logs',
        'expires_at',
    ];

    protected $casts = [
        'allowed_ips' => 'array',
        'access_logs' => 'array',
        'expires_at' => 'datetime',
    ];
}
