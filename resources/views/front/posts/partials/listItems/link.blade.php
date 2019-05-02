<div class="mb-24">
    <header class="mb-6 pb-2 border-b border-paper-darker">
        <h2 class="text-2xl font-serif font-bold leading-tight mb-1">
            <a href="{{ $post->url }}">{{ $post->title }}</a>
        </h2>
        <div class="text-gray-darker text-sm">
            <span class="inline-block w-5">🔗</span>
            {{ $post->publish_date->format('l, j F Y') }}
        </div>
    </header>
    <section class="markup pl-5">
        {!! $post->formatted_text !!}
    </section>
</div>
