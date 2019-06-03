<!DOCTYPE html>

<meta charset="utf-8">
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

<style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
<link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>

<script src="{{ mix('js/app.js') }}" defer></script>
