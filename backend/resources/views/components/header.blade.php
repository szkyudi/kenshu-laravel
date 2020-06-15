<header>
    <h1><a href="{{ route('index') }}">Kenshu Laravel</a></h1>
    <span>
        @auth
        <a href="{{ route('user', ['screen_name' => Auth::user()->screen_name ]) }}">マイページ</a>
        <form action="{{ route('logout') }}" method="POST">@csrf <button>ログアウト</button></form>
        @endauth
        @guest
        <a href="{{ route('login')}}">ログイン</a>
        <a href="{{ route('register')}}">新規登録</a>
        @endguest
    </span>
</header>
