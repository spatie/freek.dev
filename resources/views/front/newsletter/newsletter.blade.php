<html lang="">
<head>
    <title>{{ $campaign->subject }}</title>
    <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
</head>
<body>
@include('front.newsletter.partials.block')

{!! $campaign->webview_html !!}
</body>
</html>
