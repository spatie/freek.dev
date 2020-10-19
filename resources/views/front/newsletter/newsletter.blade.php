<html>
<head>
<style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
<link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
    <title>{{ $campaign->subject }}</title>
</head>
<body>

<div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-orange-100 border-b-5 border-orange-200 text-xs text-gray-700 {{ $class ?? '' }} markup">
    <p class="mb-3">
        Every two weeks I send out a newsletter like this one, containing lots of interesting stuff for the modern PHP developer.
        Subscribe to get the next edition in your mailbox
    </p>
    @include('front.newsletter.partials.form', ['class' => 'mb-3'])
</div>

<div>
    <div style="position:relative;padding-top:56.25%;">
        <iframe src="{{ $campaign->webViewUrl() }}" frameborder="0" allowfullscreen
                style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
    </div>
</div>
</body>
</html>
