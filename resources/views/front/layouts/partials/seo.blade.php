@if(isset($seo))
    {{ $seo }}
@else

    <meta name="description" content="Freek Van der Herten writes about Laravel, PHP and AI. Co-owner of Spatie, maintainer of 300+ open source packages with over 2 billion downloads.">

    <meta property="og:site_name" content="freek.dev">
    <meta property="og:locale" content="en_US">
    <meta property="og:description" content="Freek Van der Herten writes about Laravel, PHP and AI. Co-owner of Spatie, maintainer of 300+ open source packages with over 2 billion downloads.">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:image" content="https://freek.dev/images/avatar-boxed.jpg"/>
    {{--
    <script type='application/ld+json'>
    {
        "@context":"http:\/\/schema.org",
        "@type":"WebSite",
        "@id":"#website",
        "url":"https:\/\/freek.dev\/",
        "name":"freek.dev",
        "alternateName":"A blog on modern PHP and Laravel"
    }

    </script>
    --}}

    {{--
    <script type='application/ld+json'>
    {
        "@context":"http:\/\/schema.org",
        "@type":"Person",
        "sameAs":["https:\/\/x.com\/freekmurze"],
        "@id":"#person",
        "name":"Freek Van der Herten"
    }

    </script>
    --}}
@endif
