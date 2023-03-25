<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $fillable = [
        'remote_host',
        'user',
        'remote_user',
        'time_stamp',
        'http_method',
        'url_path',
        'protocol_version',
        'http_status_code',
        'bytes_sent',
        'referer_url',
        'user_agent',
        'forwarded_info',

    ];
}
