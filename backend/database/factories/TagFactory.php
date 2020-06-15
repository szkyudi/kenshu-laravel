<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;

// SeederからPostを経由して作成することもできる
$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->slug(1),
    ];
});
