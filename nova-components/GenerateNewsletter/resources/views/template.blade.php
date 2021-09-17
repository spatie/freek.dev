Hi,<br />
<br />
welcome to the {{ $editionNumber }} freek.dev newsletter!<br />
<br />
Here are a couple of interesting links<br />
<br />
@foreach($recentPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a><br />
    {{ $post->newsletter_excerpt }}<br />
    <br />
@endforeach
<br />
@if(count($communityLinks))
Community links<br />
<br />
@foreach($communityLinks as $link)
    <a href="{{ $link->url }}">{{ $link->title }}</a> (submitted by {{ $link->user->name }})<br />
    <br />
@endforeach
@endif
<br />
Old posts<br />
<br />
@foreach($oldPosts as $post)
    <a href="{{ $post->promotional_url }}">{{ $post->title }}</a><br />
@endforeach
<br />
<a href="::unsubscribeUrl::">Unsubcribe</a><br />
<a href="::webViewUrl::">View mail in browser</a><br />
<br />
Did you like this newsletter?<br />
<a href="{{ route('newsletter.like', ['edition' => $editionNumber]) }}">Yes</a><br />
<br />
DISCOUNT-FOR-FREEK-DEV-READERS<br />
<br />
This mail was sent using <a href="https://mailcoach.app">Mailcoach</a><br />
<br />
Thank you so much for reading!<br />
<br />
<br />
<br />
<br />
Freek
