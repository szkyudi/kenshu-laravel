<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Image extends Model
{
    protected $fillable = [
        'url',
    ];

    public function getUrl()
    {
        if (strpos($this->url, 'placeholder.com')) {
            return $this->url;
        } else {
            return Storage::url($this->url);
        }
    }
}
