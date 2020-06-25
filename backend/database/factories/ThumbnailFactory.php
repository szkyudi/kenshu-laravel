<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Thumbnail;
use Faker\Generator as Faker;

// SeederからPostを経由して作成する必要がある
$factory->define(Thumbnail::class, function (Faker $faker) {
    return [
        'url' => "https://via.placeholder.com/120x63?text=".$faker->unique()->slug(1),
    ];
});
