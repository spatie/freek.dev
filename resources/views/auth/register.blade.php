@extends('front.layouts.app', [
    'title' => 'Register',
])

@section('content')
    <div>Register</div>

    <div>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name">Name</label>

                <div>
                    <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                    @error('name')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="email">E-mail address</label>

                <div>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') }}" required autocomplete="email">

                    @error('email')
                    <span role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>
            </div>

            <div>
                <label for="password">Password</label>

                <div>
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
                           required autocomplete="new-password">

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
                    <input id="password-confirm" type="password" name="password_confirmation" required
                           autocomplete="new-password">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        Register
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
