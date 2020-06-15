@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
@csrf

<div>
    <label for="screen_name">{{ __('User ID') }}</label>
    <input id="screen_name" type="text" class="@error('screen_name') is-invalid @enderror" name="screen_name" value="{{ old('screen_name') }}" required autocomplete="screen_name" autofocus>
    @error('screen_name')
        <strong>{{ $message }}</strong>
    @enderror
</div>
<div>
    <label for="password">{{ __('Password') }}</label>
    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
    @error('password')
        <strong>{{ $message }}</strong>
    @enderror
</div>
<div>
    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
    <label for="remember">
        {{ __('Remember Me') }}
    </label>
</div>

<button type="submit" class="btn btn-primary">
    {{ __('Login') }}
</button>

@if (Route::has('password.request'))
    <a class="btn btn-link" href="{{ route('password.request') }}">
        {{ __('Forgot Your Password?') }}
    </a>
@endif
</form>
@endsection
