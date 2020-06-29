<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Tag;
use App\Post;

class TagControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexTags()
    {
        $tags = [
            'foo' => factory(Tag::class)->create(["name" => 'foo']),
            'bar' => factory(Tag::class)->create(["name" => 'bar']),
            'baz' => factory(Tag::class)->create(["name" => 'baz']),
        ];

        factory(Post::class)->create()->tags()->save($tags['foo']);
        factory(Post::class)->create()->tags()->save($tags['bar']);

        $response = $this->get(route('tags'));

        $response
            ->assertStatus(200)
            ->assertSee($tags['foo']->name)
            ->assertSee($tags['bar']->name)
            ->assertDontSee($tags['baz']->name);
    }

    public function testShowTag()
    {
        $tag = factory(Tag::class)->create(["name" => 'foo']);
        $post_open = $tag->posts()->save(factory(Post::class)->states('open')->make());
        $post_future = $tag->posts()->save(factory(Post::class)->states('future')->make());
        $post_close = $tag->posts()->save(factory(Post::class)->states('close')->make());

        $response = $this->get(route('tag', $tag));

        $response
            ->assertStatus(200)
            ->assertViewIs('tag')
            ->assertSee($post_open->title)
            ->assertDontSee($post_future->title)
            ->assertDontSee($post_close->title);
    }
}
