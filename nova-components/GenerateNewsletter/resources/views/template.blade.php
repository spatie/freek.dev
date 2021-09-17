Hi,

welcome to the {{ $editionNumber }} freek.dev newsletter!

Here are a couple of interesting links

@foreach($recentsPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a>
    {{ $post->newsletter_excerpt }}
@endforeach

Community links

@foreach($communityLinks->count() as $communityLink)
    <a href="{{ $link->url }}">{{ $link->title }}</a> (submitted
    by {{ $link->user->name }})
@endforeach

Old posts

@foreach($oldPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a>
@endforeach

<a href="::unsubscribeUrl::">Unsubcribe</a>
<a href="::webViewUrl::">View mail in browser</a>

Did you like this newsletter?
<a href="{{ route('newsletter.like', ['edition' => $editionNumber]) }}">Yes</a>

DISCOUNT-FOR-FREEK-DEV-READERS

This mail was sent using <a href="https://mailcoach.app">Mailcoach</a>

Thank you so much for reading!



Freek
