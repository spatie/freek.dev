<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link href="https://github.com/freekmurze" rel="me">
@if($title ?? null)
<title>{{ $title }} - Freek Van der Herten's blog on Laravel, PHP and AI</title>
@else
<title>Freek Van der Herten's blog on Laravel, PHP and AI</title>
@endif
@if($canonical ?? null)
<link rel="canonical" href="{{ $canonical }}" />
@endif
@include('feed::links')
@include('front.layouts.partials.seo')

@vite(['resources/js/app.js'])

<link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
<link href="https://x.com/freekmurze" rel="me">

@php
echo '<script type="application/ld+json">' . json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'freek.dev',
    'url' => 'https://freek.dev',
    'description' => "Freek Van der Herten's blog on Laravel, PHP and AI",
    'author' => [
        '@type' => 'Person',
        'name' => 'Freek Van der Herten',
        'url' => 'https://freek.dev/about',
    ],
    'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => [
            '@type' => 'EntryPoint',
            'urlTemplate' => 'https://freek.dev/search?query={search_term_string}',
        ],
        'query-input' => 'required name=search_term_string',
    ],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . '</script>';
@endphp
</head>
