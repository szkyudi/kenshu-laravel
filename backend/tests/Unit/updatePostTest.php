<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use Tests\TestCase;

use App\Post;
use App\Image;
use App\Thumbnail;
use App\Tag;

class updatePostTest extends TestCase
{
    use DatabaseMigrations;

    public function testUpdateInvalidPost()
    {
        Storage::fake('local');
        $post = $this->createValidPost();

        $post_data = [
            'title' => 'Valid title',
            'body' => 'Valid body',
            'tags' => ['validTag', 'invalid tag'],
            'thumbnail' => UploadedFile::fake()->create('invalid.txt', 100, 'text/plain'),
            'delete_images' => ['invalid id', $post->images[0]->id],
            'images' => [
                UploadedFile::fake()->image('valid.jpg'),
                UploadedFile::fake()->create('invalid.gif', 100, 'image/gif')
            ],
        ];
        $this->actingAs($post->user)->post(
            route('post.update', ['user' => $post->user, 'post' => $post]),
            $post_data
        );
        $this->assertDatabaseHas('posts', ['title' => $post->title]);
        $this->assertDatabaseHas('thumbnails', ['url' => $post->thumbnail->url]);
        foreach($post->tags as $tag) {
            $this->assertDatabaseHas('tags', ['name' => $tag->name]);
        }
        foreach($post->images as $image) {
            $this->assertDatabaseHas('images', ['url' => $image->url]);
        }
    }

    public function testUpdateValidPost()
    {
        Storage::fake('local');
        $post = $this->createValidPost();

        $post_data = [
            'title' => 'Valid title',
            'body' => 'Valid body',
            'tags' => ['validTag', '有効なタグ'],
            'thumbnail' => UploadedFile::fake()->image('valid.jpeg'),
            'delete_images' => [$post->images[0]->id],
            'images' => [
                UploadedFile::fake()->image('valid.jpg'),
                UploadedFile::fake()->image('valid.png')
            ],
        ];
        $this->actingAs($post->user)->post(
            route('post.update', ['user' => $post->user, 'post' => $post]),
            $post_data
        );
        $this->assertDatabaseHas('posts', ['title' => $post_data['title']]);
        $this->assertDatabaseMissing('thumbnails', ['url' => 'placeholder.png']);
        $this->assertDatabaseCount('post_tag', 2);
        $this->assertDatabaseCount('images', 4);
    }

    private function createValidPost()
    {
        $post = factory(Post::class)->create();
        $post->thumbnail()->save(factory(Thumbnail::class)->make(['url' => 'placeholder.png']));
        $post->tags()->saveMany(factory(Tag::class, 3)->make());
        $post->images()->saveMany(factory(Image::class, 3)->make());

        return $post;
    }
}
