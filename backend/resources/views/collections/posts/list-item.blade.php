<li>
    @isset($post->thumbnail)
        <img src="{{ $post->thumbnail->getUrl() }}" width="120">
    @endisset
    <a href="{{ route('post', ['user' => $post->user, 'post' => $post]) }}">{{ $post->title }}</a>
    @isset($post->tags)
        @foreach ($post->tags as $tag)
            <a href="{{ route('tag', ['tag' => $tag]) }}">#{{ $tag->name }}</a>
        @endforeach
    @endisset
    - by <a href="{{ route('user', ['user' => $post->user]) }}">{{ "@".$post->user->screen_name }}</a>
    <span>{{ $post->published_at }}</span>
</li>
