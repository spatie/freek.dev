@component('mail::message')
Hi,

welcome to the freek.dev newsletter.  Every two weeks you can expect some nice links to cool stuff on Laravel, PHP and JavaScript in your mailbox.

If you already want to read some stuff, here are links to the latest newsletters:
@foreach($campaigns as $campaign)
- [{{ $campaign->title }}]({{ $campaign->webviewUrl() }}) - sent on {{ $campaign->sent_at->format('jS F Y') }}
@endforeach

Here are some blog posts I recently published on [freek.dev](https://freek.dev):
@foreach($posts as $post)
- [{{ $post->title }}]({{ $post->url }})
@endforeach

Thanks for subscribing!


Freek
@endcomponent
