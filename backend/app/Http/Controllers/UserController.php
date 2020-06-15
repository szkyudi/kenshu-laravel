<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($screen_name)
    {
        $auth_user = Auth::user();
        $user = User::where('screen_name', $screen_name)->firstOrFail();

        $posts = $user->posts();
        if ($auth_user != $user) {
            $posts = $posts->where([
                ['is_open', true],
                ['published_at', '<=', Carbon::now()],
            ]);
        }
        $posts = $posts->orderBy('published_at', 'desc')->get();

        return view('user', ['user' => $user, 'posts' => $posts]);
    }
}
