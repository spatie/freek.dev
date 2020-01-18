@component('mail::message')
Hi,

A link titled "[{{ $link->title }}]($link->url)" was submitted by {{ $link->user->email }}. You can approve or reject this link [here](/nova/resources/links/{{ $link->id }}).

Kr,



Your blog
@endcomponent
