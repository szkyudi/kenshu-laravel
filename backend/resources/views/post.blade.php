@extends('layouts.app')

@section('title')
    {{ $post->title }} - Laravel
@endsection

@section('content')
    @auth
    <a href="{{ route('post.edit', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug])}}">編集</a>
    @endauth
    <h1>{{ $post->title }}</h1>
    {{-- TODO: 本番ではコメントを外す --}}
    {{-- <div><img src="{{ $post->thumbnail->thumbnailable->url }}" width="940"></div>
    @if ($post->images)
    <div>
        @foreach ($post->images as $image)
        <img width="231" src="{{ $image->url }}">
        @endforeach
    </div>
    @endif
    <div>{{ $post->published_at }}</> --}}
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
