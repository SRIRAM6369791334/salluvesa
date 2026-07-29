<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'subject',
        'message',
        'ip_address',
        'user_agent',
        'status',
    ];
}
