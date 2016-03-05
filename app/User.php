<?php

namespace Artsenal;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Auth\Authenticatable;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Cmgmyr\Messenger\Traits\Messagable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract,
                                    CanResetPasswordContract,
                                    SluggableInterface
{
    /* use Authorizable was removed so that Entrust can work with Laravel >= 5.1.11
    this means that Gates won't work and that we'll use Entrust instead */
    use Authenticatable, CanResetPassword, SluggableTrait, Messagable, EntrustUserTrait;


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $dates = ['date_of_birth'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'role_id', 'date_of_birth', 'sex', 'description', 'location',
        'image_name', 'image_path', 'thumbnail_path'];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

    public function getAllFollowers($id){
        $All_Followers_Of_The_User = DB::table('followers')->where('user_id', $id)->lists('follower_id');
        return $All_Followers_Of_The_User;
    }

    public function getAllServices($id){
        $services = DB::table('service_user')->join('services', 'service_id', '=', 'services.id')->where('user_id', $id)->get();
        return $services;
    }

    public function getAllUpcomingEvents(){
        if($this->hasRole('artist'))
            $events = DB::table('events')->where('artist_user_id', $this->id)->where('time', '>', Carbon::now())->get();
        else
            $events = DB::table('events')->where('venue_user_id', $this->id)->where('time', '>', Carbon::now())->get();

        return $events;
    }

    public function Album(){

        return $this->hasMany('Artsenal\Album');
    }

    public function Song(){

        return $this->hasMany('Artsenal\Song');
    }

    public function threads()
    {
        return $this->belongsToMany(Thread::class, 'participants', 'user_id', 'thread_id')
            ->withTimestamps()
            ->groupBy('thread_id')
            ->latest('updated_at');
    }

}
