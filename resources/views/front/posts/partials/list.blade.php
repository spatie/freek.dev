@foreach($posts as $post)
    <article class="mb-20">
        @include("front.posts.partials.listItems.{$post->type}")
    </article>
@endforeach
