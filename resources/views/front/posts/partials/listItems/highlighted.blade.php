<div class="mb-24 bg-paper-dark px-12 py-10 border border-paper-darker" style="box-shadow: 4px 4px 0 0 var(--paper-darker)">
    <div class="flex flex-col items-center">
        <header class="mb-8 w-2/3">
            <h2 class="text-3xl font-serif font-bold mb-2 leading-tight text-center">
                <a href="{{ $post->url }}">{{ $post->title }}</a>
            </h2>
            <div class="text-gray-darker text-center">
                🌟
                {{ $post->publish_date->format('l, j F Y') }}
            </div>
        </header>
        <div class="markup text-lg">
            {!! $post->excerpt !!}
        </div>
    </div>
</div>
