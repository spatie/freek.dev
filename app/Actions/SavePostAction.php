<?php

namespace App\Actions;

use App\Models\Post;
use App\Rules\TweetUrl;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SavePostAction
{
    /** @param array<string, mixed> $input */
    public function execute(array $input, ?Post $post = null): Post
    {
        $post ??= new Post(['published' => false, 'original_content' => false, 'send_automated_tweet' => false]);

        $validated = Validator::make($input, [
            'title' => [$post->exists ? 'sometimes' : 'required', 'required', 'string', 'max:255'],
            'text' => [Rule::requiredIf(! $post->exists && empty($input['shared_tweet_url'])), 'nullable', 'string'],
            'shared_tweet_url' => ['nullable', 'string', 'max:255', new TweetUrl],
            'shared_tweet_author' => ['nullable', 'string', 'max:255'],
            'shared_tweet_text' => ['nullable', 'string', 'max:20000'],
            'publish_date' => ['nullable', 'date'],
            'published' => ['boolean'],
            'original_content' => ['boolean'],
            'external_url' => ['nullable', 'url', 'max:255'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255'],
            'send_automated_tweet' => ['boolean'],
            'author_twitter_handle' => ['nullable', 'string', 'max:255'],
            'series_slug' => ['nullable', 'string', 'max:255'],
        ])->validate();

        $attributes = Arr::except($validated, 'tags');
        $effectiveAttributes = array_replace($post->getAttributes(), $attributes);
        $url = $effectiveAttributes['shared_tweet_url'] ?? null;

        if ($url && $url !== $post->shared_tweet_url) {
            if (empty($attributes['shared_tweet_text']) || empty($attributes['shared_tweet_author'])) {
                $tweet = (new FetchSharedTweetAction)->execute($url);
                $attributes['shared_tweet_text'] = $attributes['shared_tweet_text'] ?? $tweet['shared_tweet_text'];
                $attributes['shared_tweet_author'] = $attributes['shared_tweet_author'] ?? $tweet['shared_tweet_author'];
            }
        }

        Validator::make(array_replace($effectiveAttributes, $attributes), $url ? [
            'shared_tweet_author' => ['required', 'string', 'max:255'],
            'shared_tweet_text' => ['required', 'string', 'max:20000'],
        ] : [
            'text' => ['required', 'string'],
        ])->validate();

        $post->fill($attributes)->save();

        if (array_key_exists('tags', $validated)) {
            $post->syncTags($validated['tags']);
        }

        return $post->refresh();
    }
}
