Hi there!

Welcome to the {{ $editionNumber }} freek.dev newsletter!

Here are a couple of links I hope you'll enjoy as much as I did.

@foreach($recentPosts as $post)
@if ($post->original_content)⭐ @endif[{!! html_entity_decode($post->title)  !!}]({{ $post->promotional_url }})<br/>
{!! html_entity_decode($post->newsletter_excerpt) !!}

@endforeach

<br />

@if(count($communityLinks))
# Community links

In this section you'll find links submitted by others. [Let me know](https://freek.dev/community) if you did write or stumbled across a blog post, tutorial or video that might be interesting to appear in this section

@foreach($communityLinks as $link)
[{!! html_entity_decode($link->title) !!}]({{ $link->url }}) (submitted by {{ $link->user->name }})

@endforeach
@endif

<br />

@if (count($oldPosts))
# Old posts

Here are a couple of links from a while ago!

@foreach($oldPosts as $post)
[{!! html_entity_decode($post->title) !!}]({{ $post->promotional_url }})

@endforeach
@endif

<br />

# Did you like this newsletter?

I take a lot of time curating the right links for you. You could do me a favor by either (spreading the word)[{{ route('newsletter.like', ['edition' => $editionNumber]) }}] and letting others know about my newsletter.

Alternatively, you could consider picking up one of the paid products my team and I have worked on:

- [All spatie products](https://spatie.be/products)
- [Oh Dear](https://ohdear.app)
- [Mailcoach](https://mailcoach.app)
- [Flare](https://flareapp.io)

If you have any questions, remarks or thoughts about this newsletter, simply hit reply!

Thank you so much for reading!
<br />
<br />
<br />
Freek

You are receiving this newsletter because you subscribed at [freek.dev](https://freek.dev)
[Unsubscribe from this newsletter](::unsubscribeUrl::)
This mail was sent using [Mailcoach](https://mailcoach.app)
