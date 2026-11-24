<?php

use App\Models\Post;
use Illuminate\Support\Facades\DB;

it('repairs the requested SEO links without deleting content or republishing posts', function () {
    $externalUrls = [
        2981 => 'https://ma.ttias.be/catching-sql-performance-issues-in-phpunit-and-pest-as-part-of-your-test-infrastructure/',
        1229 => 'https://ma.ttias.be/from-laravel-echo-server-to-laravel-websockets-to-reverb/',
        1196 => 'https://ma.ttias.be/how-to-size-scale-your-laravel-queues/',
        1233 => 'https://ma.ttias.be/our-gitlab-ci-pipeline-for-laravel-applications-oh-dear-blog/',
        1850 => 'https://ma.ttias.be/how-we-added-a-favicons-to-our-site-list/',
        2643 => 'https://ma.ttias.be/making-sure-laravels-debug-mode-is-always-disabled-in-production/',
        2874 => 'https://ma.ttias.be/typehinting-laravel-validation-rules-using-phpstans-type-aliases/',
        1895 => 'https://ma.ttias.be/making-our-laravel-test-suite-ready-for-parallel-testing/',
        2953 => 'https://ma.ttias.be/the-effects-of-the-cloudflare-outage-on-oh-dear/',
        2137 => 'https://ohdear.app/features/dns-monitoring',
        2419 => 'https://ohdear.app/features/lighthouse-seo-monitoring',
    ];
    $archivedIds = [2157, 2231, 2242, 2319, 3043];
    $posts = collect([...array_keys($externalUrls), ...$archivedIds])->mapWithKeys(function (int $id) {
        $post = Post::factory()->create([
            'id' => $id,
            'title' => "Article {$id}",
            'text' => "Preserved excerpt {$id}.",
            'external_url' => "https://example.com/dead-{$id}",
            'publish_date' => '2022-06-15 12:00:00',
            'send_automated_tweet' => true,
        ]);

        return [$id => $post];
    });
    $deadUrl = 'https://ohdear.app/news-and-updates/a-fresh-new-look-for-oh-dear';
    $redesign = Post::factory()->create([
        'id' => 2343,
        'text' => "We launched the [first redesign of Oh Dear]({$deadUrl}). The rest stays.",
    ]);
    $unrelated = Post::factory()->create(['external_url' => 'https://example.com/keep']);

    foreach ([...$archivedIds, $unrelated->id] as $id) {
        DB::table('site_search_documents')->insert([
            'index_name' => 'blog',
            'document_id' => (string) $id,
            'url' => ($posts[$id] ?? $unrelated)->url,
        ]);
    }

    $migration = require database_path('migrations/2026_11_24_133103_repair_oh_dear_post_links.php');
    $migration->up();
    $migration->up();

    foreach ($externalUrls as $id => $url) {
        $post = $posts[$id]->fresh();

        expect($post->external_url)->toBe($url);

        $this->get($post->url)
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.$url.'" />', false)
            ->assertSee('href="'.e($post->external_url_with_utm).'"', false)
            ->assertHeaderMissing('site-search-do-not-index');
    }

    foreach ($posts as $id => $original) {
        $saved = $original->fresh();

        expect($saved->archived)->toBe(in_array($id, $archivedIds))
            ->and($saved->text)->toBe($original->text)
            ->and($saved->html)->toBe($original->html)
            ->and($saved->publish_date->toDateTimeString())->toBe('2022-06-15 12:00:00')
            ->and($saved->updated_at->equalTo($original->updated_at))->toBeTrue();
    }

    $this->get($redesign->url)
        ->assertOk()
        ->assertSee('We launched the first redesign of Oh Dear. The rest stays.')
        ->assertDontSee($deadUrl);

    expect($redesign->fresh()->text)->toBe('We launched the first redesign of Oh Dear. The rest stays.')
        ->and($unrelated->fresh()->external_url)->toBe('https://example.com/keep')
        ->and($unrelated->fresh()->archived)->toBeFalse()
        ->and(Post::count())->toBe(18)
        ->and(DB::table('site_search_documents')->pluck('document_id')->all())->toBe([(string) $unrelated->id]);
});
