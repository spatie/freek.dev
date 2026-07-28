<?php

use App\Services\Utm\UtmParameters;
use App\Services\Utm\UtmTagger;

beforeEach(function () {
    config()->set('utm.tracked_domains', ['ohdear.app']);

    $this->utmParameters = new UtmParameters('freek.dev', 'referral', 'blogpost-1-my-post');

    $this->query = 'utm_source=freek.dev&utm_medium=referral&utm_campaign=blogpost-1-my-post';
});

it('tags a url on a tracked domain', function () {
    expect(UtmTagger::tagUrl('https://ohdear.app/pricing', $this->utmParameters))
        ->toBe("https://ohdear.app/pricing?{$this->query}");
});

it('tags a url on a subdomain of a tracked domain', function () {
    expect(UtmTagger::tagUrl('https://www.ohdear.app', $this->utmParameters))
        ->toBe("https://www.ohdear.app?{$this->query}");
});

it('appends to an existing query string', function () {
    expect(UtmTagger::tagUrl('https://ohdear.app/docs?page=2', $this->utmParameters))
        ->toBe("https://ohdear.app/docs?page=2&{$this->query}");
});

it('keeps the fragment at the end', function () {
    expect(UtmTagger::tagUrl('https://ohdear.app/docs#installation', $this->utmParameters))
        ->toBe("https://ohdear.app/docs?{$this->query}#installation");
});

it('leaves a url that already carries utm parameters alone', function () {
    $url = 'https://ohdear.app?utm_source=somewhere-else';

    expect(UtmTagger::tagUrl($url, $this->utmParameters))->toBe($url);
});

it('leaves urls that are not on a tracked domain alone', function (string $url) {
    expect(UtmTagger::tagUrl($url, $this->utmParameters))->toBe($url);
})->with([
    'https://spatie.be/products',
    'https://notohdear.app',
    'https://ohdear.app.evil.com',
    '/relative/path',
    '#anchor',
    'mailto:freek@spatie.be',
    '',
]);

it('tags hrefs in html', function () {
    $html = '<p><a href="https://ohdear.app">Oh Dear</a> and <a href="https://spatie.be">Spatie</a></p>';

    expect(UtmTagger::tagHtml($html, $this->utmParameters))
        ->toContain('href="https://ohdear.app?utm_source=freek.dev&amp;utm_medium=referral&amp;utm_campaign=blogpost-1-my-post"')
        ->toContain('href="https://spatie.be"');
});

it('tags hrefs wrapped in single quotes', function () {
    $html = "<a href='https://ohdear.app'>Oh Dear</a>";

    expect(UtmTagger::tagHtml($html, $this->utmParameters))
        ->toContain("href='https://ohdear.app?utm_source=freek.dev&amp;utm_medium=referral");
});

it('decodes an html encoded query string before tagging', function () {
    $html = '<a href="https://ohdear.app/docs?a=1&amp;b=2">Oh Dear</a>';

    expect(UtmTagger::tagHtml($html, $this->utmParameters))
        ->toContain('href="https://ohdear.app/docs?a=1&amp;b=2&amp;utm_source=freek.dev');
});

it('tags markdown links', function () {
    $markdown = '[Oh Dear](https://ohdear.app) and [Spatie](https://spatie.be)';

    expect(UtmTagger::tagMarkdown($markdown, $this->utmParameters))
        ->toBe("[Oh Dear](https://ohdear.app?{$this->query}) and [Spatie](https://spatie.be)");
});

it('keeps the title of a markdown link', function () {
    $markdown = '[Oh Dear](https://ohdear.app "Uptime monitoring")';

    expect(UtmTagger::tagMarkdown($markdown, $this->utmParameters))
        ->toBe("[Oh Dear](https://ohdear.app?{$this->query} \"Uptime monitoring\")");
});

it('can track multiple domains', function () {
    config()->set('utm.tracked_domains', ['ohdear.app', 'mailcoach.app']);

    expect(UtmTagger::tagUrl('https://mailcoach.app', $this->utmParameters))
        ->toBe("https://mailcoach.app?{$this->query}");
});
