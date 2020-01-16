@extends('front.layouts.app', [
    'title' => 'Log in',
])

@section('content')
    <div>{{ __('Login') }}</div>

    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <label for="email">E-mail address</label>

                <div>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password"> Password</label>

                <div>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
                           required autocomplete="current-password">

                    @error('password')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div>
                <div>
                    <div>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">
                            Remember me
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        {{ __('Login') }}
                    </button>

                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>

                    <a href="{{ route('register') }}">
                        No account yet?
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
