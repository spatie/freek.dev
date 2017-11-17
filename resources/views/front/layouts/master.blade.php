<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="alternate" type="application/atom+xml" title="murze.be RSS Feed" href="/feed">
    <title>@yield('title') - Freek Van der Herten's blog on PHP and Laravel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    @include('front.layouts._partials.seo')
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/front.css') }}">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<div id="app" class="container mx-auto">
    <header>
        @include('front.layouts._partials.navigation')
    </header>

    <div class="flex flex-col lg:flex-row">


        <main class="lg:w-3/4 mr-4">
            @yield('content')
        </main>

        <div class="lg:w-1/4">
            @include('front.layouts._partials.carbon')
            @include('front.layouts._partials.newsletter')
        </div>


    </div>

    <footer class="px-4 mx-auto border-t py-6 mt-6 text-center text-sm sm:text-base">
        <a href="https://twitter.com/freekmurze">@freekmurze</a>
        &nbsp; • &nbsp;
        <a href="/feed">RSS</a>
        &nbsp; • &nbsp;
        <a href="/advertising">Advertising</a>
    </footer>
</div>

<script src="{{ mix('js/front.js') }}"></script>
</body>
</html>
