@extends('front.layouts.app', [
    'title' => 'Send password reset link',
])

@section('content')
    <div class="markup mb-8">
        <h1>Reset password</h1>

        <div>
            @if (session('status'))
                <div role="alert">
                    {{ session('status') }}
                </div>
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
    </div>
@endsection
