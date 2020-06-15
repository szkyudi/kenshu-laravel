@extends('layouts.app')

@section('title')
{{ $user->name }}{{ '@' }}{{ $user->screen_name }}さん - Laravel
@endsection

@section('content')
    <h1>{{ $user->name }}{{ '@' }}{{ $user->screen_name }}さんの投稿</h1>
    @auth
        <a href="{{ route('post.create', $user->screen_name) }}">新規作成</a>
    @endauth
    @include('collections.posts.list', ['posts' => $user->posts])
@endsection
