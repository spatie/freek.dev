<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
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

        foreach ($externalUrls as $id => $url) {
            Post::query()->whereKey($id)->toBase()->update(['external_url' => $url]);
        }

        $archivedPosts = Post::query()->whereKey([2157, 2231, 2242, 2319, 3043])->get();

        Post::query()->whereKey($archivedPosts->modelKeys())->toBase()->update(['archived' => true]);

        DB::table('site_search_documents')
            ->whereIn('url', $archivedPosts->map(fn (Post $post) => $post->url))
            ->delete();

        if ($post = Post::find(2343)) {
            $deadUrl = 'https://ohdear.app/news-and-updates/a-fresh-new-look-for-oh-dear';

            Post::query()->whereKey($post->id)->toBase()->update([
                'text' => str_replace("[first redesign of Oh Dear]({$deadUrl})", 'first redesign of Oh Dear', $post->text),
                'html' => str_replace('<a href="'.$deadUrl.'">first redesign of Oh Dear</a>', 'first redesign of Oh Dear', $post->html),
            ]);
        }
    }
};
