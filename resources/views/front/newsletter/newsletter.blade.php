<html>
<head>
    <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
    <title>{{ $campaign->subject }}</title>
</head>
<body>

<div class="sm:m-4 flex justify-center">
    <div
        class="p-4 sm:p-6 md:p-8 bg-orange-100 border-b-5 border-orange-200 text-xs text-gray-700 {{ $class ?? '' }} space-y-2 max-w-2xl">
        <p>
            Every two weeks I send out a newsletter like this one, containing lots of interesting stuff for the modern
            PHP
            developer.
        </p>
        <p>
            Subscribe to get the next edition in your mailbox.
        </p>
        @include('front.newsletter.partials.form', ['class' => 'mb-3'])
    </div>
</div>

<iframe src="{{ $campaign->webviewUrl() }}" class="w-screen h-screen"></iframe>

</body>
</html>
