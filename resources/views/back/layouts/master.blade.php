<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin | murze.be</title>

    <!-- Styles -->
    <link href="{{ asset('css/back.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="container mx-auto">
    <header>
        <div id="navigation" class="flex text-sm pt-4 py-2 font-medium">
            <div class="hidden lg:inline lg:w-1/4">
                <a class="text-black" href="/">murze.be <br /> <div class="text-grey">A blog on Laravel & PHP</div></a>
            </div>
            <div class="flex-1 lg:w-3/4 items-end">
                <nav>
                    @auth
                        {{ Menu::back() }}
                    @endauth
                </nav>
            </div>
        </div>
    </header>
        @include('back.layouts._partials.flashMessage')

        @yield('content')

    <script src="{{ asset('js/back.js') }}"></script>
</div>
</body>
</html>
