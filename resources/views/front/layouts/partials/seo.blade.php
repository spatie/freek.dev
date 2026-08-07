@php
    $pageDescription = $description ?? 'Freek Van der Herten writes about Laravel, PHP and AI. Co-owner of Spatie, maintainer of 300+ open source packages with over 2 billion downloads.';
@endphp

<meta name="description" content="{{ $pageDescription }}">

<meta property="og:site_name" content="freek.dev">
<meta property="og:locale" content="en_US">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:description" content="{{ $pageDescription }}">

@isset($seo)
    {{ $seo }}
@endisset
