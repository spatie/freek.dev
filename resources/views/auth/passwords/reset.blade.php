@extends('front.layouts.app', [
    'title' => 'Reset password',
])

@section('content')
    <div>{{ __('Reset Password') }}</div>

    <div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email">{{ __('E-Mail Address') }}</label>

                <div>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror"
                           name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div >
                <label for="password">{{ __('Password') }}</label>

                <div>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror"
                           name="password" required autocomplete="new-password">

                    @error('password')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <div>
                    <input id="password-confirm" type="password" name="password_confirmation"
                           required autocomplete="new-password">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
