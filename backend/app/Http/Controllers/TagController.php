<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('tags', ['tags' => $tags]);
    }

    public function show(Tag $tag)
    {
        return view('tag', ['tag' => $tag]);
    }
}
