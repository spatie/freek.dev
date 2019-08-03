<?php

namespace App\Models\Concerns;

interface Tweetable
{
    public function toTweet(): string;

    public function onAfterTweet(string $tweetUrl): void;
}
