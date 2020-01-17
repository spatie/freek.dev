@extends('front.layouts.app', [
    'title' => 'Log in',
])

@section('content')
    <div class="markup mb-8">
        <h1>Login</h1>
    </div>

    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            @include('front.components.inputField', [
                'label' => 'E-mail',
                'name' => 'email',
                'type' => 'Email'
            ])

            @include('front.components.inputField', [
                'label' => 'Password',
                'name' => 'password',
                'type' => 'password'
            ])

            <div class="mt-4">
                <label class="flex items-center">

                    <input class="form-checkbox" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <span class="ml-2">Remember me</span>
                </label>
            </div>

            <div class="mt-4">
                @include('front.components.button', ['label' => 'Login'])

                <span class="text-xs text-gray-700">
                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
&nbsp;
                    <a href="{{ route('register') }}">
                        No account yet?
                    </a>
                </span>
            </div>
        </form>
    </div>
@endsection
