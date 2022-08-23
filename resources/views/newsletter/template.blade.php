Hi there!

Welcome to the {{ $editionNumber }} freek.dev newsletter!

Here are a couple of links of which I hope you'll enjoy that as much as I did.

@foreach($recentPosts as $post)
@if ($post->original_content)⭐ @endif[{{ $post->title  }}]({{ $post->promotional_url }})<br/>
{{ $post->newsletter_excerpt }}

@endforeach

<br />

@if(count($communityLinks))
# Community links

In this section you'll find links submitted by others. [Let me know](https://freek.dev/community) if you did write or stumbled across a blog post, tutorial or video that might be interesting to appear in this section

@foreach($communityLinks as $link)
[{{ $link->title }}]({{ $link->url }}) (submitted by {{ $link->user->name }})

@endforeach
@endif

<br />

@if (count($oldPosts))
# Old posts

Here are a couple of links from a while ago!

@foreach($oldPosts as $post)
[{{ $post->title }}]({{ $post->promotional_url }}) (submitted by {{ $link->user->name }})

@endforeach
@endif

<br />

# Did you like this newsletter?

I take a lot of time curating the right links for you. You could do me a favor by either [{{ route('newsletter.like', ['edition' => $editionNumber]) }}](spreading the word) and letting others know about my newsletter.

Alternatively you could consider picking up one of the paid products my team and I have worked on:

- [All spatie products](https://spatie.be/products)
- [Oh Dear](https://ohdear.app)
- [Flare](https://flareapp.io)

For each of the above you can use this coupon code to get a discount:
DISCOUNT-FOR-FREEK-DEV-READERS<br>

If you have any questions, remarks or thoughts about this newsletter, simply hit reply!

Thank you so much for reading!
<br />
<br />
<br />
Freek

You are receiving this newsletter because you subscribed at [freek.dev](https://freek.dev)
[Unsubscribe from this newsletter](::unsubscribeUrl::)
This mail was sent using [Mailcoach](https://mailcoach.app)
