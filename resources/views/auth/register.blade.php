<x-app-layout title="Register">


    <div class="markup mb-8">
        <h1>Register</h1>


        <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <x-input-field label="Name" name="name"/>

                <x-input-field label="E-mail" name="email" type="email"/>

                <x-input-field label="Twitter username (optional)" name="twitter_handle" :required="false"/>

                <x-input-field label="Password" name="password" type="password"/>

                <x-input-field label="Confirm password" name="password_confirmation" type="password"/>

                <div class="mt-4">
                    <label class="flex items-center">

                        <input class="form-checkbox" type="checkbox" name="newsletter"
                               id="newsletter" {{ old('newsletter') ? 'checked' : '' }}>

                        <span class="text-sm ml-2">Subscribe me to <a href="/newsletter">the freek.dev newsletter</a>, a newsletter published once every two weeks with useful links on PHP, Laravel and JavaScript</span>
                    </label>
                </div>

                <div class="mt-4">
                    <x-submit-button label="Register"/>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
