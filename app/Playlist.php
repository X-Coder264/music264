<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Playlist extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slugPlaylist',
    ];

    protected $table = 'playlist';

    protected $fillable = array('name','user_id', 'song_id','name');

    public function User()
    {
        return $this->belongsTo('Artsenal\User','user_id', 'id');
    }

    public function Songs(){

        return $this->hasMany('Artsenal\Song');
    }

}
