<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_key_id',
        'endpoint',
        'ip_address',
    ];

    public function apiKey()
    {
        return $this->belongsTo(ApiKey::class);
    }
}
