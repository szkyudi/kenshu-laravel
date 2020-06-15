<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;
use App\Thumbnail;

class IndexControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testSeePostIsOpen()
    {
        $post = factory(Post::class)->states('open')->create();
        $post->thumbnail()->save(factory(Thumbnail::class)->make());
        $response = $this->get(route('index'));
        $response
            ->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->thumbnail->getUrl());
    }

    public function testDontSeePostIsClose()
    {
        $post = factory(Post::class)->states('close')->create();
        $response = $this->get(route('index'));
        $response
            ->assertStatus(200)
            ->assertDontSee($post->title);
    }

    public function testDontSeePostIsFuture()
    {
        $post = factory(Post::class)->states('future')->create();
        $response = $this->get(route('index'));
        $response
            ->assertStatus(200)
            ->assertDontSee($post->title);
    }

    public function testNoPosts()
    {
        $response = $this->get(route('index'));
        $response
            ->assertStatus(200)
            ->assertSee('記事が見つかりませんでした');
    }
}
