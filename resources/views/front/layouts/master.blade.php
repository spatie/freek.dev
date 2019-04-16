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

        <main class="flex items-start">
            <div class="w-2/3 pr-8">
                @yield('content')
            </div>
            <div class="flex-1 pl-8 flex flex-col items-end justify-between" style="min-height: calc(100vh - 10.5rem)">
                <div class="text-xs mb-4 mt-32" style="max-width: 11rem"><div id="carbonads" class="bg-paper-dark leading-tight"><span><span class="carbon-wrap"><a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-img block mb-3" target="_blank" rel="noopener"><img src="https://cdn4.buysellads.net/uu/1/41312/1547504724-bugsnaglogopattern260x200.png" alt="" border="0" height="100" width="130"></a><a href="https://srv.carbonads.net/ads/click/x/GTND42QMC6AI427YCKSLYKQMCWYIL27NCWAI5Z3JCWBI6K3UCABIT2JKC6BIPKQYF6ADEK3EHJNCLSIZ?segment=placement:murzebe;" class="carbon-text block px-4 pb-4" target="_blank" rel="noopener">Swift &amp; straightforward bug fixes for your web &amp; mobile apps. Try Bugsnag free.</a></span><a href="http://carbonads.net/?utm_source=murzebe&amp;utm_medium=ad_via_link&amp;utm_campaign=in_unit&amp;utm_term=carbon" class="carbon-poweredby block pt-1 text-right text-gray bg-paper" target="_blank" rel="noopener">ads via Carbon</a><img src="https://www.bugsnag.com/by-role/software-engineer/?utm_source=carbon&amp;utm_medium=cpc&amp;utm_content=software-engineer&amp;utm_campaign=2019-q1&amp;utm_term=swift-bugs" border="0" height="1" width="1" style="display:none"></span></div></div>
                <section class="text-xs text-gray-darker mb-3">
                    <a href="#">RSS</a>
                    <span class="inline-block px-1"></span>
                    <a href="#">Twitter</a>
                    <span class="inline-block px-1"></span>
                    <a href="#">Advertising</a>
                </section>
            </div>
        </main>

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
