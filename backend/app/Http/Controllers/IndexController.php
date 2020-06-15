<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use App\Post;
use App\User;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function show()
    {
        $posts = Post::where([
            ['is_open', true],
            ['published_at', '<=', Carbon::now()],
        ])
        ->orderBy('published_at', 'desc')
        ->get();

        return view('index', ['posts' => $posts]);
    }
}
