@component('mail::message')
Hi,

A link titled "[{{ $link->title }}]({{ $link->url }})" was submitted by {{ $link->user->email }}.

{{ $link->text }}

You can approve or reject this link [here](https://freek.dev/nova/resources/links/{{ $link->id }}).

Kr,



Your blog
@endcomponent
