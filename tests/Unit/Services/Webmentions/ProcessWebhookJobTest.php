<?php

use App\Models\Post;
use App\Services\Webmentions\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;

uses(TestCase::class);

it('can convert a webhook payload to a webmention', function () {
    Post::factory()->create([
       'id' => 1241,
    ]);

    $webhookCall = WebhookCall::create([
        'name' => 'webmentions',
        'payload' => getStub('payload.json'),
    ]);

    (new ProcessWebhookJob($webhookCall))->handle();

    $this->assertDatabaseHas('webmentions', [
        'webmention_id' => '642349',
        'post_id' => 1241,
        'type' => 'reply',
        'author_name' => 'Duy Ha Nguyen',
        'author_url' => 'https://twitter.com/DuyNguyenHa',
        'author_photo_url' => 'https://webmention.io/avatar/pbs.twimg.com/ce13341be3d1444d22543bf8601b9c264d1318f6eb46767a77ac5db017bbdebd.png',
        'interaction_url' => 'https://twitter.com/DuyNguyenHa/status/1147126667162165248',
        'text' => 'totally agree with you',
    ]);
});

// Helpers
function getStub(string $name): array
{
    return json_decode(file_get_contents(__DIR__ . "/stubs/{$name}"), true);
}
