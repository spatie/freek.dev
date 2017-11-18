<li class="pb-2 pt-2 border-t">
    <a href="{{ action('Front\PostsController@detail', [$post->slug]) }}">
        {{ $post->formatted_title }}
    </a>
    <div class="flex content-center text-xs pt-2 mb-2">
        <div class="flex flex-col justify-center text-grey">
            {{ $post->publish_date->format('F d, Y') }}
        </div>

        @if ($post->tags->count())
            <div class="flex flex-col justify-center">&nbsp; | &nbsp;</div>
        @endif

        @include('front.posts._partials.tags')
    </div>

    {{--
    <div>
        {{ $post->excerpt }}
    </div>
    --}}
</li>