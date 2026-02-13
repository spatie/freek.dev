<x-app-layout title="Reset password">

    <h2 class="text-xl font-bold mb-6">Reset password</h2>

    <form method="POST" action="{{ route('password.update') }}" class="max-w-sm">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <x-input-field label="E-mail" name="email" type="email"/>
        <x-input-field label="Password" name="password" type="password"/>
        <x-input-field label="Confirm password" name="password_confirmation" type="password"/>

        <x-submit-button label="Reset password"/>
    </form>

</x-app-layout>
