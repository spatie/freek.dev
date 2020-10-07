<html>
<head>
    <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
</head>

<body class="pl-32 pr-32 pt-8">
<x-post-header :post="$post" class="mb-8">
    {!! $post->formatted_text !!}
</x-post-header>
</body>
</html>
