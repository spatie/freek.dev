<li class="pb-2 pt-2 border-t">
    <a href="{{ action('Front\PostsController@detail', [$post->slug]) }}">
        {{ $post->formatted_title }}
    </a>
    <div class="flex items-center text-xs pt-2 mb-2">
        <span class="text-grey">
            {{ $post->publish_date->format('F d, Y') }}
        </span>

        @if ($post->tags->count())
            <span class="text-grey-light">&nbsp; | &nbsp;</span>
        @endif

        @include('front.posts._partials.tags')
    </div>

    {{--
    <div>
        {{ $post->excerpt }}
    </div>
    --}}
</li>
