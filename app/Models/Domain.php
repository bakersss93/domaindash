<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\DnsRecord;

class Domain extends Model
{
    use HasFactory;

    protected $fillable = [
        'domain_name',
        'customer_id',
        'auto_renew',
        'renewal_date',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function dnsRecords()
    {
        return $this->hasMany(DnsRecord::class);
    }
}
