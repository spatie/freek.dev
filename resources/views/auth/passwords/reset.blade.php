<x-app-layout title="Reset password">
    <div class="markup mb-8">
        <h1>Reset password</h1>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

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

            @include('front.components.inputField', [
                'label' => 'Confirm password',
                'name' => 'password_confirmation',
                'type' => 'password'
            ])

            <div class="mt-4">
                @include('front.components.button', ['label' => 'Reset password'])
            </div>
        </form>
    </div>
</x-app-layout>
