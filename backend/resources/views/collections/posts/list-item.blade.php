<li>
    @isset($post->thumbnail)
        <img src="{{ $post->thumbnail->getUrl() }}" width="120">
    @endisset
    <a href="{{ route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
    @isset($post->tags)
        @foreach ($post->tags as $tag)
            <a href="{{ route('tag', ['name' => $tag->name]) }}">#{{ $tag->name }}</a>
        @endforeach
    @endisset
    - by <a href="{{ route('user', ['screen_name' => $post->user->screen_name]) }}">{{ "@".$post->user->screen_name }}</a>
    <span>{{ $post->published_at }}</span>
</li>
