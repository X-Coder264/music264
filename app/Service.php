<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Service extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'services';

    protected $fillable = ['service'];

    protected $sluggable = [
        'build_from' => 'service',
        'save_to'    => 'slug',
    ];
}
