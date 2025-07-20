<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SSLService extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_name',
        'client_id',
        'expiration_date',
        'details',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
