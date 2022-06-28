<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

@isset($title)
<title>{{ $title }} - Freek Van der Herten's blog on PHP, Laravel and JavaScript</title>
@else
<title>Freek Van der Herten's blog on PHP, Laravel and JavaScript</title>
@endisset

@include('feed::links')
@include('front.layouts.partials.seo')

@vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>

<script src="/scope.js" defer></script>

<link href="https://twitter.com/freekmurze" rel="me">
<link rel="webmention" href="https://webmention.io/freek.dev/webmention" />
<link rel="pingback" href="https://webmention.io/freek.dev/xmlrpc" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>

<livewire:styles />
<x-comments::styles />
