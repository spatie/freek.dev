@extends('back.layouts.master')

@section('content')

    <div class="flex justify-center align-middle pt-8 flex items-center justify-center">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="mb-4">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
                    E-mail
                </label>
                <input name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email"
                       type="text" placeholder="Username">
                @if ($errors->has('email'))
                    <p class="text-red text-xs italic">{{ $errors->first('email') }}</p>
                @endif
            </div>
            <div class="mb-6">
                <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
                    Password
                </label>
                <input placeholder="Password" name="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3"
                       id="password" type="password">
                @if ($errors->has('password'))
                    <p class="text-red text-xs italic">{{ $errors->first('password') }}</p>
                @endif
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded" type="button">
                    Sign In
                </button>
            </div>
        </form>
    </div>
@endsection
