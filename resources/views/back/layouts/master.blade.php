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
<div id="app">
        @include('back.layouts._partials.flashMessage')

        @auth
            {{ Menu::back() }}
        @endauth

        @yield('content')

    <script src="{{ asset('js/back.js') }}"></script>
</div>
</body>
</html>
