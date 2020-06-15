<li>
    {{-- TODO: 本番ではコメントを外す --}}
    {{-- <img src="{{ $post->thumbnail->thumbnailable->url }}" width="120"> --}}
    <a href="{{ route('post', ['screen_name' => $post->user->screen_name, 'slug' => $post->slug]) }}">{{ $post->title }}</a>
    <a href="{{ route('user', ['screen_name' => $post->user->screen_name]) }}">{{ $post->user->screen_name }}</a>
    <span>{{ $post->published_at }}</span>
</li>
