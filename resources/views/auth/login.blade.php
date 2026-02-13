<x-app-layout title="Log in">
    <x-slot:sidebarTop>
        <div class="text-[13px] leading-relaxed text-gray-400 space-y-3">
            <p>Log in to submit links to the <a href="{{ route('community.index') }}" class="underline hover:text-black">community section</a>.</p>
            <p>Share blog posts, tutorials, and videos with the Laravel and PHP community.</p>
        </div>
    </x-slot:sidebarTop>

    <h2 class="text-xl font-bold mb-6">Log in</h2>

    <form method="POST" action="{{ route('login') }}" class="max-w-sm">
        @csrf

        <x-input-field label="E-mail" name="email" type="email"/>
        <x-input-field label="Password" name="password" type="password"/>

        <div class="mb-5">
            <label class="flex items-center gap-2">
                <input class="rounded border-gray-300 text-gray-900 focus:ring-gray-400" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center gap-4">
            <x-submit-button label="Log in"/>

            <div class="text-sm text-gray-500 space-x-3">
                <a href="{{ route('password.request') }}" class="hover:text-black transition-colors">Forgot password?</a>
                <a href="{{ route('register') }}" class="hover:text-black transition-colors">Register</a>
            </div>
        </div>
    </form>
</x-app-layout>
