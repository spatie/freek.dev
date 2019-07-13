<?php

namespace App\Services\Twitter;

use Symfony\Component\HttpClient\NativeHttpClient;

class PublicTwitter
{
    /** @var \Symfony\Component\HttpClient\HttpClient */
    private $httpClient;

    public function __construct(NativeHttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getEmbedHtml(string $tweetUrl)
    {
        $response = $this->httpClient->request(
            'GET',
            'https://publish.twitter.com/oembed',
            ['query' => [
                'url' => $tweetUrl,
                'dnt' => true,
                'hide_thread' => true,
                'hide_media' => true,
            ]]
        );

        return $response->toArray()['html'];
    }
}
