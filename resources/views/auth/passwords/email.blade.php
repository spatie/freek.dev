@extends('front.layouts.app', [
    'title' => 'Send password reset link',
])

@section('content')
    <div class="markup mb-8">
        <h1>Reset password</h1>

        @if (session('status'))
            <div
                class="mt-2 py-2 px-2 flex-1 bg-green-500 focus:outline-none md:mb-0 text-white text-2xs">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            @include('front.components.inputField', [
                'label' => 'E-mail',
                'name' => 'email',
                'type' => 'Email'
            ])

            <div class="mt-4">
                @include('front.components.button', ['label' => 'Send password reset link'])
            </div>
        </form>
    </div>
@endsection
