<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ReflectionMethod;

use App\Http\Controllers\PostController;
use App\Post;

class createImagesTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateImages()
    {
        Storage::fake('local');
        $post = factory(Post::class)->create();
        $images = [
            UploadedFile::fake()->image('dummy1.jpeg'), // Valid
            UploadedFile::fake()->image('dummy2.png'), // Valid
            UploadedFile::fake()->create('dummy3.gif', 100, 'image/gif') // Invalid
        ];
        $controller = new PostController;
        $ref = new ReflectionMethod($controller, 'createImages');
        $ref->setAccessible(true);

        $this->assertDatabaseCount('images', 0);
        $ref->invoke($controller, $images, $post);
        $this->assertDatabaseCount('images', 2);
    }
}
