<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Post;
use App\User;

class IndexController extends Controller
{
    public function show()
    {
        $posts = Post::published()->get();
        return view('index', ['posts' => $posts]);
    }
}
