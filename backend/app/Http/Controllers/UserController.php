<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(User $user)
    {
        if ($user == Auth::user()) {
            $posts = $user->posts;
            $is_owner = true;
        } else {
            $posts = $user->posts()->published()->get();
            $is_owner = false;
        }

        $data = [
            'user' => $user,
            'posts' => $posts,
            'is_owner' => $is_owner
        ];

        return view('user', $data);
    }
}
