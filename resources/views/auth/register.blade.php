@extends('front.layouts.app', [
    'title' => 'Register',
])

@section('content')
    <div class="markup mb-8">
        <h1>Register</h1>


        <div>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                @include('front.components.inputField', [
                    'label' => 'Name',
                    'name' => 'name'
                ])

                @include('front.components.inputField', [
                    'label' => 'E-mail',
                    'name' => 'email',
                    'type' => 'email'
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
                    <label class="flex items-center">

                        <input class="form-checkbox" type="checkbox" name="newsletter"
                               id="newsletter" {{ old('newsletter') ? 'checked' : '' }}>

                        <span class="text-sm ml-2">Subscribe me to <a href="/newsletter">the freek.dev newsletter</a>, a biweekly newsletter with useful links on PHP, Laravel and JavaScript</span>
                    </label>
                </div>

                <div class="mt-4">
                    @include('front.components.button', ['label' => 'Register'])
                </div>
            </form>
        </div>
    </div>
@endsection
