@component('mail::message')
Hi,

A link titled "[{{ $link->title }}]({{ $link->url }})" was submitted by {{ $link->user->email }}.

{{ $link->text }}

@if($existingPost)
@component('mail::panel')
⚠️ This link is already {{ $existingPost->published ? 'published' : 'scheduled' }} as [{{ $existingPost->title }}]({{ url($existingPost->url) }}) on {{ $existingPost->publish_date->format('M j, Y') }}. You probably want to reject this submission.
@endcomponent
@endif

[Approve]({{ $link->approveUrl() }})

[Approve and create post]({{ $link->approveAndCreatePostUrl() }})

[Reject link]({{ $link->rejectUrl() }})

Kr,




Your blog
@endcomponent
