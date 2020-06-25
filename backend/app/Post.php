<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'title', 'body', 'published_at', 'is_open',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function thumbnail()
    {
        return $this->hasOne('App\Thumbnail');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['slug'] = md5(uniqid(rand(), true));
    }
}
