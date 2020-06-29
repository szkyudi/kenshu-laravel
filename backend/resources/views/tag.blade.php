@extends('layouts.app')

@section('title')
{{ $tag->name }} - Laravel
@endsection

@section('content')
    <h1>"{{ $tag->name }}"のタグがついた投稿</h1>
    @include('collections.posts.list', ['posts' => $posts])
@endsection
