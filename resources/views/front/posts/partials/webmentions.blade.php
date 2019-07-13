<div class="markup">
    <h2>Comments</h2>

    <div class="-mx-4 sm:mx-0 p-4 sm:p-6 md:p-8 bg-blue-100 border-b-5 border-blue-200 text-sm text-gray-700 mb-8">
        You can comment on this post by replying to <a target="_blank" href="{{ $post->tweet_url }}">this tweet</a>.

        @if(count($post->webmentions) === 0)
            <br/>
            <br/>
            All replies, retweets and likes will be listed below.
        @endif
    </div>
</div>

@foreach($post->webmentions as $webmention)
    <div class="mb-6 text-sm">
        <div class="flex items-center">
            <div class="mr-2">
                <img class="h-8 w-8 rounded-full mx-auto" src="{{ $webmention->author_photo_url }}"/>
            </div>
            <div>
                <a class="font-semibold" href="{{ $webmention->author_url }}">{{ $webmention->author_name }}</a>
                <span class="text-gray-700">
                <a href="{{ $webmention->interaction_url }}">{{ $webmention->verb }}</a> on {{ $webmention->created_at->format('jS F Y') }}
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
