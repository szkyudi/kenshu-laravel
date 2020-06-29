<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ReflectionMethod;

use App\Http\Controllers\PostController;
use App\Post;
use App\Image;

class deleteImageTest extends TestCase
{
    use DatabaseMigrations;

    public function testDeleteImage()
    {
        Storage::fake('local');
        $file = UploadedFile::fake()->image('dummy.png');
        $path = $file->store('public');
        $post = factory(Post::class)->create();
        $image = factory(Image::class)->create(['post_id' => $post->id, 'url' => $path]);
        Storage::disk('local')->assertExists($path);
        $this->assertDatabaseHas('images', ['post_id' => $post->id, 'url' => $path]);

        $controller = new PostController;
        $ref = new ReflectionMethod($controller, 'deleteImage');
        $ref->setAccessible(true);
        $ref->invoke($controller, $image);
        Storage::disk('local')->assertMissing($path);
        $this->assertDatabaseMissing('images', ['post_id' => $post->id, 'url' => $path]);
    }
}
