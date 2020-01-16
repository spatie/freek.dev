@extends('front.layouts.app', [
    'title' => 'Send password reset link',
])

@section('content')
    <div>Reset password</div>

    <div>
        @if (session('status'))
            <div role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
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
                <div>
                    <button type="submit">
                        Send password reset link
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
