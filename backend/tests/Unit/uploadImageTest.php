<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use ReflectionMethod;

use App\Http\Controllers\PostController;

class uploadImageTest extends TestCase
{
    public function testUploadValidImage()
    {
        Storage::fake('local');
        $image = UploadedFile::fake()->image('dummy.png');
        $controller = new PostController;
        $refUploadImage = new ReflectionMethod($controller, 'uploadImage');
        $refUploadImage->setAccessible(true);
        $path = $refUploadImage->invoke($controller, $image);

        Storage::disk('local')->assertExists($path);
    }

    public function testUploadInvalidImage()
    {
        Storage::fake('local');
        $image = UploadedFile::fake()->create('dummy.gif', 100, 'image/gif');
        $controller = new PostController;
        $refUploadImage = new ReflectionMethod($controller, 'uploadImage');
        $refUploadImage->setAccessible(true);
        $path = $refUploadImage->invoke($controller, $image);

        $this->assertSame(null, $path);
    }
}
