@if($post->tags)
    <ul class="flex flex-wrap list-reset content-center">
        @foreach($post->tags->sortBy->name as $tag)
            <li class="tag">
                <a href="{{ action('Front\TaggedPostsController@index', $tag->slug) }}">{{ $tag->name }}</a>
            </li>
        @endforeach
    </ul>
@endif