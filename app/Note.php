<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'title',
        'note',
        'user_id',
        'is_deleted',
    ];

    protected $hidden = [
        'is_deleted'
    ];
}
