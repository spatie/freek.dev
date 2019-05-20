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

    <div id="app" class="max-w-4xl mx-auto px-12">
        @include('front.layouts.partials.header')

        @include('front.layouts.partials.flashMessage')

        <main>
            @yield('content')
        </main>

        {{-- <div>
            @include('front.layouts.partials.carbon')
<<<<<<< HEAD
            @include('front.layouts.partials.adsense')
        </div> --}}
=======
        </div>

>>>>>>> master

        <footer class="text-xs text-gray-darker mb-3 text-center">
            <a href="https://twitter.com/freekmurze">RSS</a>
            <span class="inline-block px-1"></span>
            <a href="/feed">Twitter</a>
            <span class="inline-block px-1"></span>
            <a href="/advertising">Advertising</a>
        </footer>
    </div>
</body>
</html>
