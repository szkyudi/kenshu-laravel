<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Post;
use App\User;
use App\Image;
use App\Tag;
use App\Http\Requests\UpdatePost;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('owner')->except('show');
    }

    public function create(User $user)
    {
        return view('edit', ['user' => $user]);
    }

    public function store(UpdatePost $request, User $user)
    {
        $request->validated();

        $post = $user->posts()->create(['title' => 'placeholder', 'body' => 'placeholder']);
        $post = $this->updatePost($request, $post);
        return redirect(route('post.edit', ['user' => $post->user, 'post' => $post]));
    }

    public function show(User $user, Post $post)
    {
        $is_owner = $user == Auth::user() ? true : false;
        return view('post', ['post' => $post, 'is_owner' => $is_owner]);
    }

    public function edit(User $user, Post $post)
    {
        return view('edit', ['post' => $post]);
    }

    public function update(UpdatePost $request, User $user, Post $post)
    {
        $request->validated();
        $post = $this->updatePost($request, $post);
        return redirect(route('post.edit', ['user' => $post->user, 'post' => $post]));
    }

    public function destroy(User $user, Post $post)
    {
        foreach($post->images as $image) {
            $this->deleteImage($image);
        }
        $this->deleteImage($this->thumbnail);
        $post->delete();
        return redirect(route('user', ['user' => $user]));
    }

    private function updatePost($request, $post) {
        $post->update([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
        ]);
        if($delete_images = $request->input('delete_images')) {
            foreach($delete_images as $delete_image) {
                $image = Image::find($delete_image);
                $this->deleteImage($image);
            }
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
            if($url) {
                $post->thumbnail()->updateOrCreate(['post_id' => $post->id], ['url' => $url]);
            }
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

    private function deleteImage($image) {
        Storage::delete($image->url);
        $image->delete();
    }
}
