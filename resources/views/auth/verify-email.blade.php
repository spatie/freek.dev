<x-app-layout title="Verify email">
    <div class="markup mb-8">
        <h1>Verify your email</h1>
    </div>

    <div>
        To continue you must have a verified email address. Click on the button below to receive a mail that contains a link to verify your email.
    </div>

    <div class="mt-4">
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <x-submit-button label="Send verification mail"/>
        </form>
    </div>
</x-app-layout>
