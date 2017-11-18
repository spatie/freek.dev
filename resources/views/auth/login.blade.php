@extends('back.layouts.master')

@section('content')

    <div class="flex items-center justify-center pt-8">
        <div class="bg-white rounded border-2 max-w-sm flex-1 my-8">
            <div class="bg-grey-lighter px-8 py-4 text-grey-darker font-bold">Login</div>
            <form class="px-8 py-6" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="mb-4">
                    <label class="block text-grey-dark text-sm font-bold mb-2" for="email">
                        E-mail
                    </label>
                    <input name="email" class="appearance-none border rounded w-full p-3 text-grey-dark" id="email"
                        type="text" placeholder="Username">
                    @if ($errors->has('email'))
                        <p class="text-red text-xs italic">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="mb-6">
                    <label class="block text-grey-dark text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input placeholder="Password" name="password" class="appearance-none border rounded w-full p-3 text-grey-darker"
                        id="password" type="password">
                    @if ($errors->has('password'))
                        <p class="text-red text-xs italic">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-3 px-4 rounded" type="button">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
