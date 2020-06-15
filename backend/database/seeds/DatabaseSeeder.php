<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $tags = factory(App\Tag::class, 10)->create();
        $users = factory(App\User::class, 10)->create();

        foreach($users as $user) {
            $posts = factory(App\Post::class, rand(0, 5))->create(['user_id' => $user->id]);
            if ($posts->count()) {
                foreach($posts as $post) {
                    $post->tags()->saveMany($tags->random(rand(0, 3)));
                    $post->images()->saveMany(factory(App\Image::class, rand(0, 5))->make());
                    $post->thumbnail()->save(factory(App\Thumbnail::class)->make());
                }
            }
        }
    }
}
