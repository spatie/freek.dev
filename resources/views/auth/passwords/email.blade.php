<x-app-layout title="Send password reset link">

    <div class="markup mb-8">
        <h1>Reset password</h1>

        @if (session('status'))
            <div
                class="mt-2 py-2 px-2 flex-1 bg-green-500 focus:outline-none md:mb-0 text-white text-2xs">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <x-input-field label="E-mail" name="email" type="email" />

            <div class="mt-4">
                <x-submit-button label="Send password reset link" />
            </div>
        </form>
    </div>

</x-app-layout>
