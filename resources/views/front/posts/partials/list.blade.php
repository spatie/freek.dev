<main class="posts bg-grey mx-12 mb-12">
    @foreach($posts as $post)
        <article class="post {{ $post->original_content ? 'post--large' : '' }} p-12 pb-16 bg-paper">
            <header class="mb-4">
                <h2 class="mb-4 italic font-bold text-2xl leading-tight tracking-wide">
                    {{ $post->title }}
                </h2>
                <div class="flex mb-6 text-xs text-grey-darker">
                    <p class="mr-4">{{ $post->publish_date->format('F d, Y') }}</p>
                    <ul class="flex text-blue">
                        @foreach($post->tags as $tag)
                            <li class="mr-2">#{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </header>
            <div class="bg-paper-dark pt-4">
                <img
                    class="w-full"
                    src="https://pbs.twimg.com/media/DzO-EmnXcAYFde0?format=jpg&name=medium"
                    style="transform: translateX(-1rem)"
                />
                <p class="p-8 font-serif">How to do PHP... Mission Impossible style. 😎</p>
            </div>
            <p class="text-right text-xs text-grey-darker mt-2">
                From
                <span class="text-blue">
                    @<span class="underline">SammyK</span>
                </span>
                on Twitter
            </p>
        </article>
    @endforeach
</main>

{{-- <ul style="
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 1px;
    background-color: #ddd;
">
    @foreach($posts as $post)
        <li class="bg-white" @if($loop->first) style="grid-column: 1 / -1" @endif>
            <article class="p-16">
                <h1 class="mb-8 font-sans italic font-bold {{ $loop->first ? 'text-center text-4xl' : 'w-3/4 text-3xl' }} leading-tight tracking-wide">
                    <a href="{{ route('posts.show', [$post->slug]) }}">
                        {{ $post->formatted_title }}
                    </a>
                </h1>
                <section class="{{ $loop->first ? 'text-2xl' : 'text-xl' }} font-serif leading-normal">
                    {!! $post->formatted_text !!}
                </section>
                {{-- <div class="flex items-center text-xs pt-2 mb-2">
                    <time datetime="{{ $post->publish_date->format(DateTime::ATOM) }}" class="text-grey">
                        {{ $post->publish_date->format('F d, Y') }}
                    </time>
                    @if ($post->tags->count())
                        <span class="text-grey">&nbsp; | &nbsp;</span>
                    @endif
                    @include('front.posts.partials.tags')
                </div> --}}
                {{--
                <div>
                    {{ $post->excerpt }}
                </div>
                --}}
