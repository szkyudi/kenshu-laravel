<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'url' => "https://via.placeholder.com/120x63?text=".$faker->unique()->slug(1),
    ];
});
