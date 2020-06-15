<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

// SeederからPostもしくはThumbnailを経由して作成する必要がある
$factory->define(Image::class, function (Faker $faker) {
    return [
        'url' => $faker->imageUrl(120, 63),
    ];
});
