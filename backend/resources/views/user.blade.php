@extends('layouts.app')

@section('title')
{{ $user->name }}{{ '@' }}{{ $user->screen_name }}さん - Laravel
@endsection

@section('content')
    <h1>{{ $user->name }}{{ '@' }}{{ $user->screen_name }}さんの投稿</h1>
    @if($is_owner)
        <a href="{{ route('post.create', $user) }}">新規作成</a>
    @endif
    @include('collections.posts.list', ['posts' => $posts])
@endsection
