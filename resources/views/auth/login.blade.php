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

            <div class="mt-4">
                <label class="block">
                    <span class="text-gray-700">E-mail address</span>
                    <input id="email" type="email" class="form-input mt-1 block w-full" name="email"
                           value="{{ old('email') }}" required autocomplete="email" autofocus>
                </label>
                @error('email')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
                <div>


                </div>
            </div>

            <div class="mt-4">
                <label class="block">
                    <span class="text-gray-700">Password</span>
                    <input id="password" type="password" class="form-input mt-1 block w-full" name="password"
                           value="{{ old('password') }}" required autocomplete="email" autofocus>
                </label>
                @error('password')
                <div
                    class="mt-2 py-2 px-2 flex-1 bg-red-500 focus:outline-none md:mb-0 text-white text-2xs">{{ $message }}</div>
                @enderror
                <div>


                </div>
            </div>

            <div class="mt-4">
                <label class="flex items-center">

                    <input class="form-checkbox" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <span class="ml-2">Remember me</span>
                </label>
            </div>

            <div class="mt-4">
                <button
                    class="button button-orange"
                    type="submit">Log in
                </button>

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
    </div>
@endsection
