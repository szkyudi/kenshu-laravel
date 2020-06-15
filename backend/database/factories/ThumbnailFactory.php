<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thumbnail;
use Faker\Generator as Faker;

// SeederからPostを経由して作成する必要がある
$factory->define(Thumbnail::class, function (Faker $faker) {
    return [
        'thumbnailable_id' => factory(App\Image::class),
        'thumbnailable_type' => App\Image::class
    ];
});
