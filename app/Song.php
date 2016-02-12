<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Song extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slugSong',
    ];

    protected $table = 'songs';

    protected $fillable = array('name','user_id','description','song');

    public function User()
    {
        return $this->belongsTo('Artsenal\User','user_id', 'id');
    }
}
