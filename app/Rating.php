<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function User()
    {
        return $this->belongsTo('Artsenal\User','user_id', 'id');
    }

    protected $fillable = array('song_id','user_id','value');

}
