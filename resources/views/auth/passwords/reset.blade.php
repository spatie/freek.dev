@extends('front.layouts.app', [
    'title' => 'Reset password',
])

@section('content')
    <div>Reset password</div>

    <div>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email">E-mail address</label>

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
                <label for="password">Password</label>

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
                <label for="password-confirm">Confirm password</label>

                <div>
                    <input id="password-confirm" type="password" name="password_confirmation"
                           required autocomplete="new-password">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        Reset password
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
