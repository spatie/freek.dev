<?php

namespace App\Services\Medium;

use GuzzleHttp\Client;

class Medium
{
    /** @var \GuzzleHttp\Client */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function me(): array
    {
        $response = $this->client->get('me');

        $responseArray = json_decode($response->getBody(), true);

        return $responseArray['data'];
    }

    public function createPost(string $title, string $content, array $tags, string $canonicalUrl)
    {
        $authorId = $this->me()['id'];

        $this->client->post("users/{$authorId}/posts", ['form_params' => [
            'title' => $title,
            'contentFormat' => 'html',
            'content' => "<h1>{$title}</h1>{$content}",
            'tags' => $tags,
            'canonicalUrl' => $canonicalUrl,
            'notifyFollowers' => true,
        ]]);
    }
}
