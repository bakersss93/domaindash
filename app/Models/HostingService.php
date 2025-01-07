<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostingService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'customer_id',
        'disk_usage',
        'database_usage',
        'disk_space_threshold',
        'hosting_plan',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
