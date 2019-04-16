@foreach($posts as $post)
    <article class="mb-20">
        <header class="mb-8">
            <h2 class="text-2xl font-serif font-bold mb-1 leading-tight w-3/4">
                {{ $post->title }}
            </h2>
            <div class="text-gray-darker text-sm">
                {{ $post->emoji }}
                {{ $post->publish_date->format('l, j F Y') }}
                {{-- <ul class="inline-flex text-blue">
                    @foreach($post->tags as $tag)
                        <li class="mr-2">#{{ $tag->name }}</li>
                    @endforeach
                </ul> --}}
            </div>
        </header>
        <div class="mb-3 w-24 h-1 bg-paper-dark"></div>
        <div class="markup pl-8">
            {!! $post->excerpt !!}
        </div>
    </article>
@endforeach
