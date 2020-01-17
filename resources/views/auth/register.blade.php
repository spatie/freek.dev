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
                    @include('front.components.button', ['label' => 'Register'])
                </div>
            </form>
        </div>
    </div>
@endsection
