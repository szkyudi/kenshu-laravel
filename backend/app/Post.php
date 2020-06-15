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
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'post_tag', 'post_id', 'tag_id');
    }

    public function images()
    {
        return $this->belongsToMany('App\Image', 'post_image', 'post_id', 'image_id');
    }

    public function thumbnail()
    {
        // return $this->hasOne('App\Thumbnail', 'post_id')->get()->first()->thumbnailable();
        return $this->hasOne('App\Thumbnail', 'post_id');
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['slug'] = md5(uniqid(rand(), true));
    }
}
