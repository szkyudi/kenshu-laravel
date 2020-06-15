@extends('layouts.app')

@section('title', 'Kenshu Laravel')

@section('content')
    <h1>記事一覧</h1>
    @include('collections.posts.list', $posts)
@endsection

