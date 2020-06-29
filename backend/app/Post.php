<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\User;
use App\Scopes\LatestScope;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'slug', 'title', 'body', 'published_at', 'is_open',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->attributes['slug'] = md5(uniqid(rand(), true));
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::addGlobalScope(new LatestScope);
    }

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

    public function is_close() {
        return !$this->is_open || $this->published_at > Carbon::now();
    }

    public function scopePublished($query)
    {
        return $query->where([
            ['is_open', true],
            ['published_at', '<=', Carbon::now()]
        ]);
    }
}
