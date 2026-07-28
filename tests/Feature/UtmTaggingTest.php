<?php

use App\Enums\LinkStatus;
use App\Models\Ad;
use App\Models\Link;
use App\Models\Post;
use App\Models\Video;
use App\Services\NewsletterGenerator;

beforeEach(function () {
    config()->set('utm.tracked_domains', ['ohdear.app']);

    $this->post = Post::factory()->create([
        'title' => 'My post',
        'text' => 'Try [Oh Dear](https://ohdear.app) and [Spatie](https://spatie.be).',
        'published' => true,
        'publish_date' => now()->subDay(),
        'original_content' => false,
    ]);
});

it('tags links in a post body with the blog source', function () {
    expect($this->post->html_with_utm)
        ->toContain("utm_source=freek.dev&amp;utm_medium=referral&amp;utm_campaign=blogpost-{$this->post->idSlug()}")
        ->toContain('href="https://spatie.be"');
});

it('shows tagged links on the post page', function () {
    $this->get($this->post->url)
        ->assertOk()
        ->assertSee("utm_campaign=blogpost-{$this->post->idSlug()}", escape: false);
});

it('tags links in the feed summary', function () {
    $this->post->update(['external_url' => 'https://ohdear.app/blog/some-article']);

    expect($this->post->fresh()->html_with_external_url)
        ->toContain("<a href='https://ohdear.app/blog/some-article?utm_source=freek.dev&utm_medium=referral&utm_campaign=blogpost-{$this->post->idSlug()}'>Read more</a>");
});

it('tags links in a post excerpt', function () {
    expect($this->post->excerpt)->toContain('utm_source=freek.dev');
});

it('tags the external url of a post on listing pages', function () {
    $this->post->update(['external_url' => 'https://ohdear.app/blog/some-article']);

    $this->get(route('home'))
        ->assertOk()
        ->assertSee("utm_campaign=blogpost-{$this->post->idSlug()}", escape: false);
});

it('tags a community link on the community page', function () {
    $link = Link::factory()->create([
        'url' => 'https://ohdear.app/blog/some-article',
        'status' => LinkStatus::Approved->value,
        'publish_date' => now()->subDay(),
    ]);

    expect($link->url_with_utm)
        ->toBe("https://ohdear.app/blog/some-article?utm_source=freek.dev&utm_medium=referral&utm_campaign=community-link-{$link->id}-{$link->slug}");

    $this->get(route('community.index'))
        ->assertOk()
        ->assertSee("utm_campaign=community-link-{$link->id}-{$link->slug}", escape: false);
});

it('tags links in an ad', function () {
    $ad = Ad::factory()->create([
        'text' => 'Monitor with [Oh Dear](https://ohdear.app).',
    ]);

    expect($ad->html_with_utm)
        ->toContain("utm_source=freek.dev&amp;utm_medium=banner&amp;utm_campaign=ad-{$ad->id}");
});

it('tags links in a video description', function () {
    $video = Video::create([
        'title' => 'Monitoring your site',
        'text' => 'We use [Oh Dear](https://ohdear.app).',
        'embed' => '<iframe src="https://youtube.com/embed/123"></iframe>',
    ]);

    expect($video->fresh()->html_with_utm)
        ->toContain("utm_source=freek.dev&amp;utm_medium=referral&amp;utm_campaign=video-{$video->id}-monitoring-your-site");
});

it('tags links in the newsletter with the newsletter source', function () {
    $markdown = (new NewsletterGenerator(now()->subWeek(), now(), 351))->getMarkdown();

    expect($markdown)
        ->toContain('[Oh Dear](https://ohdear.app?utm_source=newsletter&utm_medium=email&utm_campaign=freek-dev-issue-351)')
        ->toContain('Welcome to the 351st freek.dev newsletter!')
        ->toContain('[Mailcoach](https://mailcoach.app)');
});

it('tags the promotional url in a tweet and a toot', function () {
    $this->post->update(['external_url' => 'https://ohdear.app/blog/some-article']);

    $post = $this->post->fresh();

    expect($post->toTweet())
        ->toContain("https://ohdear.app/blog/some-article?utm_source=twitter&utm_medium=social&utm_campaign=blogpost-{$post->idSlug()}");

    expect($post->toToot())
        ->toContain("https://ohdear.app/blog/some-article?utm_source=mastodon&utm_medium=social&utm_campaign=blogpost-{$post->idSlug()}");
});

it('does not tag a promotional url that points to freek.dev', function () {
    expect($this->post->toTweet())->toContain($this->post->url)
        ->not()->toContain('utm_source');
});
