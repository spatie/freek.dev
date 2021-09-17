Hi there!<br/>
<br/>
Welcome to the {{ $editionNumber }} freek.dev newsletter!<br/>
<br/>
Here are a couple of links of which I hope you'll enjoy that as much as I did.
<br/>
<br/>
@foreach($recentPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a><br/>
    {{ $post->newsletter_excerpt }}<br/>
    <br/>
@endforeach
<br/>
@if(count($communityLinks))
    <b>Community links</b><br/>
    <br/>
    In this section you'll find links submitted by others. <br/>
    Did you write or stumbled across a blog post, tutorial or video that might be interesting for others? <br/>
    <a href="https://freek.dev/community">Let me know!</a> <br/>
    <br/>
    @foreach($communityLinks as $link)
        <a href="{{ $link->url }}">{{ $link->title }}</a> (submitted by {{ $link->user->name }})<br/>
        <br/>
    @endforeach
@endif
<br/>
<b>Old posts</b><br/>
<br/>
Here are a couple of links from a while ago!
<br/>

@foreach($oldPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a><br/>
    <br/>
@endforeach
<br/>

<br/>
<b>Did you like this newsletter?</b><br/>
<br/>
I take a lot of time curating the right links for you. You could do me a favor by either <a
    href="{{ route('newsletter.like', ['edition' => $editionNumber]) }}">spreading the
    word</a> and letting others know about my newsletter.<br/>
<br/>
Alternatively you could consider picking up one of the paid products my team and I have worked on:<br/>
<a href="https://spatie.be/products">All spatie products</a>
<a href="https://ohdear.app">Oh Dear</a>
<a href="https://flareapp.io">Flare</a>

For each of the above you can use this coupon code to get a discount:
<br/>DISCOUNT-FOR-FREEK-DEV-READERS<br>
<br/>
If you have any questions, remarks or thoughts about this newsletter, simply hit reply!
<br/>
Thank you so much for reading!<br/>
<br/>
<br/>
<br/>
<br/>
Freek
<br/>
<br/>
You are receiving this newsletter because you subscribed at <a href="freek.dev">https://freek.dev</a>
<a href="::unsubscribeUrl::">Unsubcribe from this newsletter</a><br/>
This mail was sent using <a href="https://mailcoach.app">Mailcoach</a><br/>

