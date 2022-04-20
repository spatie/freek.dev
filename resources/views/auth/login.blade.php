<x-app-layout title="Log in">
    <div class="markup mb-8">
        <h1>Login</h1>
    </div>

    <div>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <x-input-field label="E-mail" name="email" type="email"/>

            <x-input-field label="Password" name="password" type="password"/>


            <div class="mt-4">
                <label class="flex items-center">

                    <input class="form-checkbox" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <span class="ml-2">Remember me</span>
                </label>
            </div>

            <div class="mt-4 flex space-x-4 items-center">
                <x-submit-button label="Login"/>

                <div class="ml-4 text-xs text-gray-700">
                    <a href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
&nbsp;
                    <a href="{{ route('register') }}">
                        No account yet?
                    </a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
