<html lang="en">
<head>
    <meta charset="utf-8">

    <title>@yield('title') - Freek Van der Herten's blog on PHP and Laravel</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">

    @include('feed::links')
    @include('front.layouts.partials.seo')

    <link rel="stylesheet" href="https://use.typekit.net/cmc0uxi.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body class="font-sans bg-paper text-black">
    @include('front.layouts.partials.analytics')

    <div id="app" class="max-w-6xl mx-auto">
        @include('front.layouts.partials.header')

        @include('front.layouts.partials.flashMessage')

        @yield('content')

        {{-- <div>
            @include('front.layouts.partials.carbon')
            @include('front.layouts.partials.adsense')
        </div> --}}

        {{-- <footer>
            <a href="https://twitter.com/freekmurze">@freekmurze</a>
            &nbsp; • &nbsp;
            <a href="/feed" data-turbolinks="false">RSS</a>
            &nbsp; • &nbsp;
            <a href="/advertising">Advertising</a>
        </footer> --}}
    </div>
</body>
</html>
