<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMTPSetting extends Model
{
    use HasFactory;

    protected $table = 'smtp_settings';

    protected $fillable = [
        'send_from_email',
        'smtp_server',
        'smtp_port',
        'smtp_username',
        'smtp_password',
    ];
}
