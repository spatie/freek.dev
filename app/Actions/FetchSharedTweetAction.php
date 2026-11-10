<?php

namespace App\Actions;

use App\Rules\TweetUrl;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FetchSharedTweetAction
{
    /** @return array{shared_tweet_author: string, shared_tweet_text: string} */
    public function execute(string $url): array
    {
        Validator::make(['shared_tweet_url' => $url], [
            'shared_tweet_url' => ['required', new TweetUrl],
        ])->validate();

        try {
            $tweet = Http::acceptJson()->connectTimeout(5)->timeout(10)
                ->get('https://publish.x.com/oembed', [
                    'url' => $url,
                    'omit_script' => true,
                ])->throw()->json();
        } catch (ConnectionException|RequestException) {
            throw ValidationException::withMessages([
                'shared_tweet_url' => 'X could not load this tweet. Check the URL or enter the author and tweet text below.',
            ]);
        }

        $document = new DOMDocument;
        @$document->loadHTML('<?xml encoding="utf-8" ?>'.($tweet['html'] ?? ''), LIBXML_NONET);
        $paragraph = (new DOMXPath($document))->query('//blockquote/p')->item(0);

        if (! $paragraph || empty($tweet['author_name'])) {
            throw ValidationException::withMessages([
                'shared_tweet_url' => 'X returned no tweet text. Enter the author and tweet text below.',
            ]);
        }

        foreach (iterator_to_array($paragraph->getElementsByTagName('br')) as $lineBreak) {
            $lineBreak->parentNode->replaceChild($document->createTextNode("\n"), $lineBreak);
        }

        return [
            'shared_tweet_author' => $tweet['author_name'],
            'shared_tweet_text' => trim($paragraph->textContent),
        ];
    }
}
