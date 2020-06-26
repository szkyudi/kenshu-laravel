@extends('layouts.app')

@section('title')
タグ一覧 - Laravel
@endsection

@section('content')
    <h1>タグ一覧</h1>
    @if ($tags)
    <ul>
        @foreach ($tags as $tag)
        <li><a href="{{ route('tag', ['tag' => $tag]) }}">{{ $tag->name }}</a>({{ $tag->posts->count() }})</li>
        @endforeach
    </ul>
    @else
    <p>タグが見つかりませんでした。</p>
    @endif
@endsection
