<?php

namespace App\Http\Controllers;]

use Illuminate\Support\Facades\Auth;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostController extends Controller
{
    public function create($screen_name)
    {
        $user = Auth::user();
        if ($user->screen_name != $screen_name) {
            return redirect('login');
        }

        $post = new Post;
        $post->user = User::where('screen_name', $screen_name)->firstOrFail();
        return view('edit', ['post' => $post]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($screen_name, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('post', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($screen_nmae, $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
