@extends('layouts.app')

@section('title')
    {{ $post->title }} - Laravel
@endsection

@section('content')
    @if($is_owner)
        <a href="{{ route('post.edit', ['user' => $post->user, 'post' => $post])}}">編集</a>
    @endif
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
        <a href="{{ route('tag', $tag) }}">#{{ $tag->name }}</a>
        @endforeach
    </div>
    @endif
    <div>
        {{ $post->body }}
    </div>
@endsection
