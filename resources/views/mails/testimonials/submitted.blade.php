@component('mail::message')
Hi,

A new newsletter testimonial was submitted.

**"{{ $testimonial->text }}"**

— {{ $testimonial->author_name }}@if($testimonial->author_title), {{ $testimonial->author_title }}@endif

@if($testimonial->author_url)
Link: [{{ $testimonial->author_url }}]({{ $testimonial->author_url }})
@endif

[Approve]({{ $testimonial->approveUrl() }})

[Reject]({{ $testimonial->rejectUrl() }})

Kr,

Your blog
@endcomponent
