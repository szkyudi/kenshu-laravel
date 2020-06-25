<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use App\Post;
use App\Tag;
use App\Image;
use App\Thumbnail;

class PostControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testSeeShowPage()
    {
        $post = $this->createValidPost();
        $response = $this->get(route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
        $response->assertStatus(200)
                 ->assertSee($post->title)
                 ->assertSee($post->body)
                 ->assertSee($post->thumbnail->getUrl());

        foreach ($post->tags as $tag) {
            $response->assertSee($tag->name);
        }

        foreach ($post->images as $image) {
            $response->assertSee($image->url);
        }
    }

    public function testSeeEditBtnFromOwner()
    {
        $post = $this->createValidPost();
        $response = $this->actingAs($post->user)
                         ->get(route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
        $response->assertStatus(200)
                 ->assertSee("編集");
    }

    public function testDontSeeEditBtn()
    {
        $post = $this->createValidPost();
        $response = $this->get(route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
        $response->assertStatus(200)
                 ->assertDontSee("編集");
    }

    public function testSeeCreatePage()
    {
        $post = $this->createValidPost();
        $response = $this->actingAs($post->user)
                         ->get(route('post.create', ['screen_name' => $post->user->screen_name]));
        $response->assertStatus(200)
                 ->assertViewIs('edit');
    }

    public function testDontSeeCreatePage()
    {
        $post = $this->createValidPost();
        $response = $this->get(route('post.create', ['screen_name' => $post->user->screen_name]));
        $response->assertRedirect(route('login'));
    }

    public function testSeeEditPage()
    {
        $post = $this->createValidPost();
        $response = $this->actingAs($post->user)
                         ->get(route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
        $response->assertStatus(200)
                 ->assertViewIs('edit');
    }

    public function testDontSeeEditPage()
    {
        $post = $this->createValidPost();
        $response = $this->get(route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
        $response->assertRedirect(route('login'));
    }

    private function createValidPost()
    {
        $post = factory(Post::class)->create(['title' => 'Test title', 'body' => 'Test body']);
        $post->thumbnail()->save(factory(Thumbnail::class)->make());
        $post->tags()->saveMany(factory(Tag::class, 3)->make());
        $post->images()->saveMany(factory(Image::class, 3)->make());
        return $post;
    }
}
