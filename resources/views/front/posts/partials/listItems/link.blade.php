<header class="mb-8">
    <h2 class="text-2xl font-serif font-bold mb-1 leading-tight w-3/4">
        <a href="{{ $post->external_url }}">{{ $post->title }}</a>
    </h2>
    <div class="text-gray-darker text-sm">
        🔗
        {{ $post->publish_date->format('l, j F Y') }}
    </div>
</header>
<div class="mb-3 w-24 h-1 bg-paper-dark"></div>
<div class="markup pl-8">
    {!! $post->formatted_text !!}
</div>
