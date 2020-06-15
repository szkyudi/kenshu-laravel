@extends('layouts.app')

@section('title')
    {{ $post->title }} - Laravel
@endsection

@section('content')
    @isset($user)
        @if($post->user == $user)
            <a href="{{ route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug])}}">編集</a>
        @endif
    @endisset
    <h1>{{ $post->title }}</h1>
    <span>{{ $post->user->screen_name }}</span>
    @isset ($post->thumbnail)
        <div><img src="{{ $post->thumbnail->getUrl() }}" width="940"></div>
    @endisset
    @if ($post->images)
    <div>
        @foreach ($post->images as $image)
            <img width="231" src="{{ $image->url }}">
        @endforeach
    </div>
    @endif
    <div>{{ $post->published_at }}</>
    @if ($post->tags)
    <div>
        @foreach ($post->tags as $tag)
        <a href="{{ route('tag', $tag->name) }}">#{{ $tag->name }}</a>
        @endforeach
    </div>
    @endif
    <div>
        {{ $post->body }}
    </div>
@endsection
