@extends('layouts.app')

@section('title')
    {{ $post->title }} - Laravel
@endsection

@section('content')
    <a href="{{ route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug])}}">ページ</a>
    <form action="{{ route('post.update', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug])}}" method="POST">
        <div>タイトル</div>
        <input type="text" name="title" value="{{ old('title', $post->title) }}">
        {{-- TODO: 本番ではコメントを外す --}}
        {{-- <div><img src="{{ $post->thumbnail->thumbnailable->url }}" width="940"></div>
        @if ($post->images)
        <div>
            @foreach ($post->images as $image)
            <img width="231" src="{{ $image->url }}">
            @endforeach
        </div>
        @endif --}}
        <div>{{ $post->published_at }}</div>
        {{-- @if ($post->tags)
        <div>
            @foreach ($post->tags as $tag)
            <a href="{{ route('tag', $tag->name) }}">#{{ $tag->name }}</a>
            @endforeach
        </div>
        @endif --}}

        <div>
            <div>本文</div>
            <textarea name="body" rows="30" cols="120">{{ old('body', $post->body) }}</textarea>
        </div>

        <button>保存</button>
    </form>
@endsection
