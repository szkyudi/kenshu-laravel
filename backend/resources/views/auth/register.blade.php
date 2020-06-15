@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div>
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
            <strong>{{ $message }}</strong>
        @enderror
    </div>

    <div>
        <label for="screen_name">{{ __('User ID') }}</label>
            <input id="screen_name" type="text" class="@error('screen_name') is-invalid @enderror" name="screen_name" value="{{ old('screen_name') }}" required autocomplete="screen_name">
            @error('screen_name')
                <strong>{{ $message }}</strong>
            @enderror
        </div>
    </div>

    <div>
        <label for="name">{{ __('Name') }}</label>
        <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        @error('name')
            <strong>{{ $message }}</strong>
        @enderror
        </div>
    </div>

    <div>
        <label for="password">{{ __('Password') }}</label>
        <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
        @error('password')
            <strong>{{ $message }}</strong>
        @enderror
    </div>

    <div>
        <label for="password-confirm">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
    </div>

    <button type="submit">{{ __('Register') }}</button>
</form>
@endsection
