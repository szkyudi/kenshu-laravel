<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ReflectionMethod;

use App\Http\Controllers\PostController;
use App\Post;

class updateOrCreateThumbnailTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateVaildImage()
    {
        Storage::fake('local');
        $post = factory(Post::class)->create();
        $thumbnail = UploadedFile::fake()->image('dummy.jpeg');
        $controller = new PostController;
        $ref = new ReflectionMethod($controller, 'updateOrCreateThumbnail');
        $ref->setAccessible(true);

        $this->assertDatabaseMissing('thumbnails', ['post_id', $post->id]);
        $ref->invoke($controller, $thumbnail, $post);
        $this->assertDatabaseHas('thumbnails', ['post_id' => "$post->id"]);
    }

    public function testCreateInvaildImage()
    {
        Storage::fake('local');
        $post = factory(Post::class)->create();
        $thumbnail = UploadedFile::fake()->create('dummy.gif', 100, 'image/gif');
        $controller = new PostController;
        $ref = new ReflectionMethod($controller, 'updateOrCreateThumbnail');
        $ref->setAccessible(true);

        $this->assertDatabaseMissing('thumbnails', ['post_id', $post->id]);
        $ref->invoke($controller, $thumbnail, $post);
        $this->assertDatabaseMissing('thumbnails', ['post_id' => "$post->id"]);
    }
}
