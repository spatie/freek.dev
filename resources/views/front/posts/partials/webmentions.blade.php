@foreach($post->webmentions as $webmention)
    <div class="mb-6 text-sm">
        <div class="flex items-center">
            <div class="mr-2">
                <img class="h-8 w-8 rounded-full mx-auto" src="{{ $webmention->author_photo_url }}"/>
            </div>
            <div>
                <a class="font-semibold" href="{{ $webmention->author_url }}">{{ $webmention->author_name }}</a>
                <span class="text-gray-700">
                <a href="{{ $webmention->interaction_url }}">{{ $webmention->verb }}</a> {{ $webmention->created_at->diffForHumans() }}
            </span>
            </div>
        </div>

        @if ($webmention->type === \App\Models\Webmention::TYPE_REPLY && $webmention->text)
            <div class="mt-2">
                {{ $webmention->text }}
            </div>
        @endif
    </div>
@endforeach