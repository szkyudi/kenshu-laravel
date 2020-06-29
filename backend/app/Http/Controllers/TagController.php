<?php

namespace App\Http\Controllers;

use App\Tag;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all()->filter(function($tag) {
            return $tag->posts()->count();
        });
        return view('tags', ['tags' => $tags]);
    }

    public function show(Tag $tag)
    {
        $posts = $tag->posts()->published()->get();
        if ($posts->count() == 0) {
            abort(404);
        }
        return view('tag', ['tag' => $tag, 'posts' => $posts]);
    }
}
