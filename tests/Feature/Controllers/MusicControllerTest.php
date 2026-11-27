<?php

use function Pest\Laravel\get;

it('displays every release grouped in project order', function () {
    $response = get('/music')
        ->assertOk()
        ->assertSeeInOrder([
            'id="kobus"',
            'Even artwork',
            'Kind artwork',
            'Current artwork',
            'Wave artwork',
            'Audience artwork',
            'Draw artwork',
            'Second artwork',
            'Left artwork',
            'id="topologies"',
            'Silve artwork',
            'id="tax-shelter"',
            'Beach Architecture artwork',
            'id="jarenduren"',
            '5+9 artwork',
            '3+2 artwork',
            'D+R artwork',
        ], escape: false);

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);

    expect($xpath->query('//main//section//a[normalize-space()="Spotify"]'))->toHaveCount(13)
        ->and($xpath->query('//main//section//a[normalize-space()="Apple Music"]'))->toHaveCount(13);
});

it('loads release artwork from the uploads disk', function () {
    config()->set('filesystems.disks.uploads.url', 'https://bucket.test/uploads');

    get('/music')
        ->assertOk()
        ->assertSee('https://bucket.test/uploads/media/music/beach-architecture.jpg', escape: false)
        ->assertDontSee('https://freek.dev/uploads/media/music', escape: false);
});
