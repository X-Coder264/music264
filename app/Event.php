<?php

namespace Artsenal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Event extends Model implements SluggableInterface
{
    use SluggableTrait;

    protected $table = 'events';

    protected $guarded = [];

    protected $dates = ['time'];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];
}