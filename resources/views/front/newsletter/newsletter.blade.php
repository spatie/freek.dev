<html>

<head>
<style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
<link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
</head>
<body>

@include('front.newsletter.partials.form', ['class' => 'mb-3'])

<div>
    <div style="position:relative;padding-top:56.25%;">
        <iframe src="{{ $campaign->webViewUrl() }}" frameborder="0" allowfullscreen
                style="position:absolute;top:0;left:0;width:100%;height:100%;"></iframe>
    </div>
</div>
</body>
</html>
