<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\User;
use App\Image;
use App\Tag;
use App\Http\Requests\UpdatePost;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
    public function create($screen_name)
    {
        $user = User::where('screen_name', $screen_name)->firstOrFail();
        if (Auth::user() != $user) {
            return redirect(route('login'));
        }
        return view('edit', ['user' => $user]);
    }

    public function store(UpdatePost $request, $screen_name)
    {
        $user = User::where('screen_name', $screen_name)->firstOrFail();
        if (Auth::user() != $user) {
            return redirect(route('login'));
        }

        $request->validated();

        $post = $user->posts()->create(['title' => '', 'body' => '']);
        $post = $this->updatePost($request, $post);

        return redirect(route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
    }

    public function show($screen_name, $slug)
    {
        $user = Auth::user();
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('post', ['post' => $post, 'user' => $user]);
    }

    public function edit($screen_name, $slug)
    {
        $user = User::where('screen_name', $screen_name)->firstOrFail();
        if (Auth::user() != $user) {
            return redirect('login');
        }
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('edit', ['post' => $post, 'user' => $user]);
    }

    public function update(UpdatePost $request, $screen_name, $slug)
    {
        $user = User::where('screen_name', $screen_name)->firstOrFail();
        if (Auth::user() != $user) {
            return redirect(route('login'));
        }

        $request->validated();

        $post = Post::where('slug', $slug)->firstOrFail();
        $post = $this->updatePost($request, $post);

        return redirect(route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]));
    }

    public function destroy($screen_name, $slug)
    {
        $user = User::where('screen_name', $screen_name)->firstOrFail();
        if (Auth::user() != $user) {
            return redirect(route('login'));
        }

        $post = Post::where('slug', $slug)->firstOrFail();
        $this->deleteRelatedImages($post);
        $post->delete();

        return redirect(route('user', ['screen_name' => $screen_name]));
    }

    private function updatePost($request, $post) {
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        if($delete_images = $request->input('delete_images')) {
            $this->deleteImages(Image::find($delete_images));
        }
        if($request->hasFile('thumbnail')) {
            $this->updateOrCreateThumbnail($request->file('thumbnail'), $post);
        }
        if($images = $request->file('images')) {
            $this->createImages($images, $post);
        }
        if($tags = $request->input('tags')) {
            $this->updateOrCreateTags($tags, $post);
        }
        return $post;
    }

    private function updateOrCreateThumbnail($thumbnail, $post)
    {
        if($thumbnail->isValid()) {
            if ($post->thumbnail) {
                Storage::delete($post->thumbnail->url);
            }
            $url = $this->uploadImage($thumbnail);
            $post->thumbnail()->updateOrCreate(['post_id' => $post->id], ['url' => $url]);
        }
    }

    private function uploadImage($image)
    {
        if (in_array($image->extension(), ['jpg', 'jpeg', 'png'])) {
            return $image->store('public');
        } else {
            return null;
        }
    }

    private function createImages($images, $post)
    {
        foreach($images as $image) {
            if($image->isValid()) {
                $url = $this->uploadImage($image);
                if($url) {
                    $post->images()->create(['url' => $url]);
                }
            }
        }
    }

    private function updateOrCreateTags($tags, $post) {
        $tag_id_array = [];
        foreach (array_filter($tags, 'trim') as $tag_name) {
            $tag_id_array[] = Tag::firstOrCreate(['name' => $tag_name])->id;
        }
        $post->tags()->sync($tag_id_array);
    }

    private function deleteImages($images) {
        if ($images) {
            foreach ($images as $image) {
                Storage::delete($image->url);
                $image->delete();
            }
        }
    }

    private function deleteRelatedImages($post) {
        $this->deleteImages($post->images);
        if ($post->thumbnail) {
            Storage::delete($post->thumbnail->url);
        }
    }
}
