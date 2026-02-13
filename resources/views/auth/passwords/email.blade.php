<x-app-layout title="Reset password">

    <h2 class="text-xl font-bold mb-6">Reset password</h2>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 px-4 py-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="max-w-sm">
        @csrf

        <x-input-field label="E-mail" name="email" type="email" />

        <x-submit-button label="Send reset link" />
    </form>

</x-app-layout>
