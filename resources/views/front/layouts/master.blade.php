<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

    <title>@yield('title') - Freek Van der Herten's blog on PHP and Laravel</title>

    @include('feed::links')
    @include('front.layouts.partials.seo')

    <link rel="stylesheet" href="https://use.typekit.net/cmc0uxi.css">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body class="font-sans text-black">
    @include('front.layouts.partials.analytics')
    @include('front.layouts.partials.flashMessage')

    <div class="max-w-4xl mx-auto">
        <header class="mt-12 mb-16 px-8 leading-tight flex">
            <div class="flex items-end">
                <figure class="w-12 inline-block mr-3">
                    <a href="/"><img src="/images/murzicoon.svg" class="w-full"></a>
                </figure>
                <div class="uppercase">
                    <h1 class="text-lg tracking-wider font-black">
                        <a href="/">Freek.dev</a>
                    </h1>
                    <p class="text-sm tracking-wide font-bold text-gray-500">
                        <a href="/">
                            Laravel
                            <span class="text-gray-300">/</span>
                            PHP
                            <span class="text-gray-300">/</span>
                            JavaScript
                        </a>
                    </p>
                </div>
            </div>
        </header>
        <div class="flex items-start">
            <nav class="w-1/4 text-right leading-loose">
                {{ Menu::main()
                    ->addClass('text-sm text-gray-700 border-r px-8')
                    ->setActiveClass('font-bold text-black') }}
                <div class="mt-32 pl-8">
                    @include('front.layouts.partials.carbonDummy')
                </div>
            </nav>
            <section class="flex-1 pr-8 pl-24 pb-16">
                @yield('content')
            </section>
        </div>
    </div>
</body>
</html>
