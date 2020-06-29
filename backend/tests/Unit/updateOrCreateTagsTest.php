<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Post;
use App\Http\Controllers\PostController;
use ReflectionMethod;

class updateOrCreateTagsTest extends TestCase
{
    use DatabaseMigrations;

    public function testCreateTags()
    {
        $post = factory(Post::class)->create();
        $tags = [
            'foo',
            'bar',
            'baz'
        ];

        $controller = new PostController;
        $refUploadImage = new ReflectionMethod($controller, 'updateOrCreateTags');
        $refUploadImage->setAccessible(true);
        $refUploadImage->invoke($controller, $tags, $post);

        $this->assertDatabaseCount('post_tag', 3);
        foreach($tags as $tag) {
            $this->assertDatabaseHas('tags', ['name' => $tag]);
        }
    }
}
