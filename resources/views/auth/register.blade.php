<x-app-layout title="Register">
    <x-slot:sidebarTop>
        <div class="text-[13px] leading-relaxed text-gray-400 space-y-3">
            <p>Create an account to share interesting blog posts, tutorials, and videos with the Laravel and PHP community.</p>
            <p>After submitting a link, it will be reviewed and published to the <a href="{{ route('community.index') }}" class="underline hover:text-black">community section</a>.</p>
        </div>
    </x-slot:sidebarTop>

    <h2 class="text-xl font-bold mb-6">Register</h2>

    <form method="POST" action="{{ route('register') }}" class="max-w-sm">
        <x-honeypot />
        @csrf

        <x-input-field label="Name" name="name"/>
        <x-input-field label="E-mail" name="email" type="email"/>
        <x-input-field label="Twitter/X username (optional)" name="twitter_handle" :required="false"/>
        <x-input-field label="Password" name="password" type="password"/>
        <x-input-field label="Confirm password" name="password_confirmation" type="password"/>

        <div class="mb-5">
            <label class="flex items-start gap-2">
                <input class="mt-0.5 rounded border-gray-300 text-gray-900 focus:ring-gray-400" type="checkbox" name="newsletter" id="newsletter" {{ old('newsletter') ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Subscribe to the <a href="/newsletter" class="underline hover:text-black">freek.dev newsletter</a></span>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-submit-button label="Register"/>
            <span class="text-sm text-gray-500">Already have an account? <a href="{{ route('login') }}" class="hover:text-black transition-colors">Log in</a></span>
        </div>
    </form>
</x-app-layout>
