<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'organizacion',
        'email',
        'pais',
        'intereses',
        'message',
        'status',
        'admin_notes',
    ];
}
