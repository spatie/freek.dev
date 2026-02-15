@component('mail::message')
Hi,

**{{ $comment->commenter->name }}** ([{{ $comment->commenter->username }}](https://github.com/{{ $comment->commenter->username }})) commented on [{{ $post->title }}]({{ $post->url }}):

> {{ $comment->body }}

Kr,

Your blog
@endcomponent
