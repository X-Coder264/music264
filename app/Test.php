<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'testing';

    protected $fillable = array('text');
}
