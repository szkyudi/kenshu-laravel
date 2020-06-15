<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Post;

class IndexTest extends TestCase
{
    use DatabaseMigrations;

    public function testSeePostIsOpen()
    {
        $post = factory(Post::class)->states('open')->create();
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertSee($post->title);
    }

    public function testDontSeePostIsClose()
    {
        $post = factory(Post::class)->states('close')->create();
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertDontSee($post->title);
    }

    public function testDontSeePostIsFuture()
    {
        $post = factory(Post::class)->states('future')->create();
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertDontSee($post->title);
    }

    public function testNoPosts()
    {
        $response = $this->get('/');
        $response
            ->assertStatus(200)
            ->assertSee('記事が見つかりませんでした');
    }
}
