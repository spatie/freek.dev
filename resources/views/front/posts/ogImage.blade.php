<html>
<head>
    <style>{!! file_get_contents(public_path('css/app.css')) !!}</style>
    <link rel="stylesheet" href="https://cloud.typography.com/6194432/6581412/css/fonts.css"/>
</head>

<body class="bg-black">
<div class="flex items-center justify-center h-screen text-3xl font-extrabold text-white p-4 bg-gradient-to-br {{ $post->gradient_colors }}">
    {{ $post->title }}
</div>
</body>
</html>
