<x-app-layout title="Reset password">
    <div class="markup mb-8">
        <h1>Reset password</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <x-input-field label="E-mail" name="email" type="email"/>

            <x-input-field label="Password" name="password" type="password"/>

            <x-input-field label="Password" name="password_confirmation" type="password"/>

            <div class="mt-4">
                <x-submit-button label="Reset password"/>
            </div>
        </form>
    </div>
</x-app-layout>
