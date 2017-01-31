<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Medium extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'group_id', 'name', 'file_name', 'title', 'description', 'tag', 'media_type', 'mime_type',
        'group_priority', 'youtube_url',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function likes()
    {
        return $this->hasMany('App\Like');
    }
}
