<div>
    <img src="{{ $webmention->author_photo_url }}"/>
    <a href="{{ $webmention->author_url }}">{{ $webmention->author_name }}</a>
    {{ $webmention->verb }} {{ $webmention->created_at->diffForHumans() }}

    @if ($webmention->text)
        {{ $webmention->text }}
    @endif
</div>