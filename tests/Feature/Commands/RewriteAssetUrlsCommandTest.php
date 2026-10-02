<?php

use App\Models\Ad;
use App\Models\NewsletterTestimonial;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    config()->set('filesystems.object_storage_url', 'https://bucket.test');

    foreach (['uploads', 'admin-uploads', 'avatars', 'public', 'fonts'] as $diskName) {
        Storage::fake($diskName);
    }

    Storage::disk('uploads')->put('2015/01/equality.png', 'image');
    Storage::disk('uploads')->put('2016/02/my image.png', 'image');
    Storage::disk('admin-uploads')->put('screenshot.png', 'image');
    Storage::disk('avatars')->put('12/avatar.jpg', 'image');
    Storage::disk('public')->put('og-images/abc.jpeg', 'image');
    Storage::disk('fonts')->put('884760/font.woff2', 'font');
});

function postWithContent(string $text, ?string $html = null): Post
{
    $post = Post::factory()->create();

    Post::query()->whereKey($post->id)->toBase()->update([
        'text' => $text,
        'html' => $html ?? $text,
        'updated_at' => '2020-01-01 00:00:00',
    ]);

    return $post;
}

function rawPost(Post $post): object
{
    return Post::query()->whereKey($post->id)->toBase()->first();
}

it('rewrites absolute and relative asset urls to the public bucket', function () {
    $post = postWithContent(implode("\n", [
        '![](https://freek.dev/uploads/2015/01/equality.png)',
        '![](http://www.freek.dev/admin-uploads/screenshot.png)',
        '![](/avatars/12/avatar.jpg)',
        '<img src="//freek.dev/storage/og-images/abc.jpeg">',
        '<img src="/uploads/2016/02/my%20image.png">',
        'See https://freek.dev/uploads/2015/01/equality.png.',
    ]));

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post)->text)->toBe(implode("\n", [
        '![](https://bucket.test/uploads/2015/01/equality.png)',
        '![](https://bucket.test/admin-uploads/screenshot.png)',
        '![](https://bucket.test/avatars/12/avatar.jpg)',
        '<img src="https://bucket.test/storage/og-images/abc.jpeg">',
        '<img src="https://bucket.test/uploads/2016/02/my%20image.png">',
        'See https://bucket.test/uploads/2015/01/equality.png.',
    ]));
});

it('rewrites both the text and the html of a post', function () {
    $post = postWithContent(
        '![](/uploads/2015/01/equality.png)',
        '<p><img src="/uploads/2015/01/equality.png"></p>',
    );

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post))
        ->text->toBe('![](https://bucket.test/uploads/2015/01/equality.png)')
        ->html->toBe('<p><img src="https://bucket.test/uploads/2015/01/equality.png"></p>');
});

it('keeps urls of files that are not in the bucket', function () {
    $content = "Route::get('/uploads/{path}', ...);\n![](https://freek.dev/uploads/missing.png)";

    $post = postWithContent($content);

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post)->text)->toBe($content);
});

it('does not rewrite asset paths on other domains', function () {
    $content = '![](https://example.com/uploads/2015/01/equality.png) and example.com/uploads/2015/01/equality.png';

    $post = postWithContent($content);

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post)->text)->toBe($content);
});

it('does not rewrite font urls', function () {
    $content = '<link href="https://freek.dev/fonts/884760/font.woff2">';

    $post = postWithContent($content);

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post)->text)->toBe($content);
});

it('is idempotent', function () {
    $post = postWithContent('![](https://freek.dev/uploads/2015/01/equality.png)');

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();
    $this->artisan('app:rewrite-asset-urls')
        ->doesntExpectOutputToContain('Rewriting `posts`')
        ->assertSuccessful();

    expect(rawPost($post)->text)->toBe('![](https://bucket.test/uploads/2015/01/equality.png)');
});

it('does not save anything during a dry run', function () {
    $post = postWithContent('![](https://freek.dev/uploads/2015/01/equality.png)');

    $this->artisan('app:rewrite-asset-urls --dry-run')
        ->expectsOutputToContain("Rewriting `posts` #{$post->id}")
        ->assertSuccessful();

    expect(rawPost($post)->text)->toBe('![](https://freek.dev/uploads/2015/01/equality.png)');
});

it('can rewrite a single post', function () {
    $post = postWithContent('![](/uploads/2015/01/equality.png)');
    $otherPost = postWithContent('![](/uploads/2015/01/equality.png)');
    $ad = Ad::factory()->create(['text' => '![](/uploads/2015/01/equality.png)']);

    $this->artisan("app:rewrite-asset-urls --post={$post->id}")->assertSuccessful();

    expect(rawPost($post)->text)->toBe('![](https://bucket.test/uploads/2015/01/equality.png)')
        ->and(rawPost($otherPost)->text)->toBe('![](/uploads/2015/01/equality.png)')
        ->and(Ad::query()->toBase()->find($ad->id)->text)->toBe('![](/uploads/2015/01/equality.png)');
});

it('does not touch the updated_at column or fire model events', function () {
    $post = postWithContent('![](/uploads/2015/01/equality.png)');

    Post::saved(fn () => throw new Exception('Posts should not be saved'));

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(rawPost($post)->updated_at)->toBe('2020-01-01 00:00:00');
});

it('rewrites asset urls in ads, videos and newsletter testimonials', function () {
    $ad = Ad::factory()->create(['text' => '![](/uploads/2015/01/equality.png)']);
    $video = Video::create([
        'title' => 'Video',
        'embed' => 'embed',
        'text' => '![](https://freek.dev/admin-uploads/screenshot.png)',
    ]);
    $testimonial = NewsletterTestimonial::factory()->create(['avatar_url' => 'https://freek.dev/avatars/12/avatar.jpg']);

    $this->artisan('app:rewrite-asset-urls')->assertSuccessful();

    expect(Ad::query()->toBase()->find($ad->id))
        ->text->toBe('![](https://bucket.test/uploads/2015/01/equality.png)')
        ->html->toContain('src="https://bucket.test/uploads/2015/01/equality.png"')
        ->and(Video::query()->toBase()->find($video->id))
        ->text->toBe('![](https://bucket.test/admin-uploads/screenshot.png)')
        ->html->toContain('src="https://bucket.test/admin-uploads/screenshot.png"')
        ->and(NewsletterTestimonial::query()->toBase()->find($testimonial->id)->avatar_url)
        ->toBe('https://bucket.test/avatars/12/avatar.jpg');
});

it('fails when there is no object storage url', function () {
    config()->set('filesystems.object_storage_url', null);

    $this->artisan('app:rewrite-asset-urls')->assertFailed();
});
