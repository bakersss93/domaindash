<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'abn',
        'halo_reference',
        'itglue_org_id',
        'active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function domains()
    {
        return $this->hasMany(Domain::class);
    }

    public function hostingServices()
    {
        return $this->hasMany(HostingService::class);
    }

    public function sslServices()
    {
        return $this->hasMany(SSLService::class);
    }
}
