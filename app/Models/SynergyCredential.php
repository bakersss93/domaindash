<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SynergyCredential extends Model
{
    use HasFactory;

    protected $fillable = [
        'reseller_id',
        'api_key',
    ];
}
