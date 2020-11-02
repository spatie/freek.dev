@component('mail::message')
Hi,

A link titled "[{{ $link->title }}]({{ $link->url }})" was submitted by {{ $link->user->email }}.

{{ $link->text }}

[Approve]({{ $link->approveUrl() }})

[Approve and create post]({{ $link->approveAndCreatePostUrl() }})

[Reject link]({{ $link->rejectUrl() }})

Kr,




Your blog
@endcomponent
