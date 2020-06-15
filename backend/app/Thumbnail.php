<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thumbnail extends Model
{
    public function thumbnailable()
    {
        return $this->morphTo();
    }
}
