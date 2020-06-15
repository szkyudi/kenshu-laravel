@extends('layouts.app')

@section('title')
    @isset($post)
        {{ $post->title }} -
    @endisset
    Laravel
@endsection

@section('content')
    @isset($post)
        <a href="{{ route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]) }}">ページ</a>
    @endisset
    @if (isset($post))
        <form action="{{ route('post.update', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]) }}" method="POST" enctype="multipart/form-data">
    @else
        <form action="{{ route('post.store', ['screen_name' => $user->screen_name]) }}" method="POST" enctype="multipart/form-data">
    @endif
        @csrf
        <div>タイトル</div>
        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}">
        @error('title')
            <div>{{ $message }}</div>
        @enderror
        @isset($post->thumbnail)
            <div><img src="{{ $post->thumbnail->getUrl() }}" width="940"></div>
        @endisset
        <div><input type="file" name="thumbnail"></div>
        <div>
            <div>画像</div>
                @isset ($post->images)
                    @foreach ($post->images as $image)
                        <label>
                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}">
                            <img width="231" src="{{ $image->getUrl() }}">
                        </label>
                    @endforeach
                @endisset
                @error('delete_images')
                    <div>{{ $message }}</div>
                @enderror
                <input type="file" name="images[]">
                @error('images')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            @isset($post->published_at)
                <div>{{ $post->published_at }}</div>
            @endisset
        <div>
            <div>タグ</div>
                @isset ($post->tags)
                    @foreach ($post->tags as $tag)
                    <input type="text" name="tags[]" value={{ $tag->name }}>
                    @error('tags.*')
                        <div>{{ $message }}</div>
                    @enderror
                    @endforeach
                @endisset
                <input type="text" name="tags[]">
                @error('tags.*')
                    <div>{{ $message }}</div>
                @enderror
            @error('tags')
                <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <div>
                本文
                @error('body')
                    <div>{{ $message }}</div>
                @enderror
            </div>
            <textarea name="body" rows="30" cols="120">{{ old('body', $post->body ?? '') }}</textarea>
        </div>
        <button>保存</button>
    </form>
    @isset($post)
        <form action="{{ route('post.destroy', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]) }}" method="POST">
            @csrf
            <button>削除</button>
        </form>
    @endisset
@endsection
