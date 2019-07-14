<?php

namespace App\Services\Webmentions;

use App\Models\Post;
use App\Models\Webmention;
use Illuminate\Support\Arr;
use Spatie\Url\Url;
use Spatie\WebhookClient\ProcessWebhookJob as SpatieProcessWebhookJob;

class ProcessWebhookJob extends SpatieProcessWebhookJob
{
    public function handle()
    {
        $payload = $this->webhookCall->payload;

        if ($this->payloadHasBeenReceivedBefore($payload)) {
            return;
        }

        if (!$type = $this->getType($payload)) {
            return;
        }

        if (!$post = $this->getPost($payload)) {
            return;
        }

        Webmention::create([
            'post_id' => $post->id,
            'type' => $type,
            'webmention_id' => Arr::get($payload, 'post.wm-id'),
            'author_name' => Arr::get($payload, 'post.author.name'),
            'author_photo_url' => Arr::get($payload, 'post.author.photo'),
            'author_url' => Arr::get($payload, 'post.author.url'),
            'interaction_url' => Arr::get($payload, 'post.url'),
            'text' => Arr::get($payload, 'post.content.text'),
        ]);
    }

    private function payloadHasBeenReceivedBefore(array $payload): bool
    {
        $webmentionId = Arr::get($payload, 'post.wm-id');

        return Webmention::where('webmention_id', $webmentionId)->exists();
    }

    private function getType(array $payload): ?string
    {
        $types = [
            'in-reply-to' => Webmention::TYPE_REPLY,
            'like-of' => Webmention::TYPE_LIKE,
            'repost-of' => Webmention::TYPE_RETWEET,
        ];

        $wmProperty = Arr::get($payload, 'post.wm-property');

        if (!array_key_exists($wmProperty, $types)) {
            return null;
        }

        return $types[$wmProperty];
    }

    private function getPost(array $payload): ?Post
    {
        $url = Arr::get($payload, 'post.wm-target');

        if (!$url) {
            return null;
        }

        $postIdSlug = Url::fromString($url)->getSegment(1);

        [$postId] = explode('-', $postIdSlug);

        return Post::find($postId);
    }
}
