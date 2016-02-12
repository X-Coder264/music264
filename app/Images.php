<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Images extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $sluggable = [
        'build_from' => 'image',
        'save_to'    => 'slugImage',
    ];

    public function Album()
    {
        return $this->belongsTo('Artsenal\Album','album_id', 'id');
    }

    protected $table = 'images';

    protected $fillable = array('album_id','description','image');
}
