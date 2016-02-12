<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';

    protected $fillable = [
        'text',
        'user_id',
        'created_at'
    ];
}
