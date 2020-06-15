<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

// SeederからUserを経由して作成する必要がある
$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'slug' => $faker->unique()->uuid,
        'title' => $faker->sentence,
        'body' => $faker->paragraphs(rand(3, 5), true),
        'published_at' => $faker->dateTimeBetween('-1month', 'now')->format('Y-m-d H:i:s'),
        'is_open' => $faker->boolean(80),
    ];
});

$factory->state(Post::class, 'justnow', function(Faker $faker) {
    return [
        'published_at' => $faker->dateTimeBetween('-10seconds', '-10seconds')->format('Y-m-d H:i:s'),
    ];
});

$factory->state(Post::class, 'open', ['is_open' => true]);
$factory->state(Post::class, 'close', ['is_open' => false]);

$factory->state(Post::class, 'future', function(Faker $faker) {
    return [
        'published_at' => $faker->dateTimeBetween('3months', '3months')->format('Y-m-d H:i:s'),
    ];
});

$factory->state(Post::class, 'past', function(Faker $faker) {
    return [
        'published_at' => $faker->dateTimeBetween('-3months', '-3months')->format('Y-m-d H:i:s'),
    ];
});




