<ul>
    @foreach($posts as $post)
        @if($post->id !== 1058)
            @include('front.posts._partials.listItem')
        @endif
    @endforeach
</ul>