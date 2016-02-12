<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Artsenal\Images;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Album extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slugAlbum',
    ];

    protected $table = 'albums';

    protected $fillable = array('name','user_id','description','cover_image');

    public function Photos(){

        return $this->hasMany('Artsenal\Images');
    }
}
