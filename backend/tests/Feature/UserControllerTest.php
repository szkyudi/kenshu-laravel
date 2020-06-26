<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

use App\User;
use App\Post;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testSeeUserPosts()
    {
        $user = factory(User::class)->create(['screen_name' => 'test']);
        $post_own = factory(Post::class)->states('open')->create(['user_id' => $user->id]);
        $post_private = factory(Post::class)->states('close', 'future')->create(['user_id' => $user->id]);

        $post_others = factory(Post::class)->create();

        $response = $this->get(route('user', ['user' => $user]));

        $response
            ->assertStatus(200)
            ->assertViewIs('user')
            ->assertSee($post_own->title)
            ->assertDontSee($post_private->title)
            ->assertDontSee($post_others->title);
    }

    public function testSeePostIsUnpublishedFromAuthUser()
    {
        $post = factory(Post::class)->states('close', 'future')->create();

        Auth::login($post->user);
        $response = $this->get(route('user', ['user' => $post->user]));

        $response
            ->assertStatus(200)
            ->assertViewIs('user')
            ->assertSee($post->title);
    }

    public function testDontSeePostIsPrivate()
    {
        $post = factory(Post::class)->states('close', 'future')->create();

        $response = $this->get(route('user', ['user' => $post->user]));

        $response
            ->assertStatus(200)
            ->assertViewIs('user')
            ->assertDontSee($post->title);
    }
}
