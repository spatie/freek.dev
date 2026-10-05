<?php

namespace App\Console\Commands;

use App\Models\Ad;
use App\Models\NewsletterTestimonial;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Signature('app:rewrite-asset-urls {--dry-run} {--post= : Only rewrite the post with this id}')]
#[Description('Point freek.dev asset URLs in content to the public object storage bucket, without firing model events')]
class RewriteAssetUrlsCommand extends Command
{
    protected string $bucketUrl;

    /** @var array<string, array<string, bool>> */
    protected array $filesPerDisk = [];

    /** @var array<string, array{rows: int, rewritten: int, missing: int}> */
    protected array $summary = [];

    public function handle(): int
    {
        $bucketUrl = config('filesystems.object_storage_url');

        if (! $bucketUrl) {
            $this->error('There is no object storage url configured.');

            return self::FAILURE;
        }

        $this->bucketUrl = rtrim($bucketUrl, '/');

        if ($this->option('dry-run')) {
            $this->warn('Dry run, nothing will be saved.');
        }

        $postId = $this->option('post');

        $this->rewrite(Post::class, ['text', 'html'], function (Builder $query) use ($postId) {
            if ($postId) {
                $query->whereKey($postId);
            }
        });

        if (! $postId) {
            $this->rewrite(Ad::class, ['text', 'html']);
            $this->rewrite(Video::class, ['text', 'html']);
            $this->rewrite(NewsletterTestimonial::class, ['avatar_url']);
        }

        $this->table(
            ['Table', 'Rows changed', 'URLs rewritten', 'URLs kept (file not in bucket)'],
            collect($this->summary)->map(fn (array $counts, string $table) => [$table, ...array_values($counts)]),
        );

        $this->comment('All done!');

        return self::SUCCESS;
    }

    /**
     * @param  class-string<Model>  $modelClass
     * @param  array<int, string>  $columns
     */
    protected function rewrite(string $modelClass, array $columns, ?callable $scope = null): void
    {
        $model = new $modelClass;
        $table = $model->getTable();

        $this->summary[$table] = ['rows' => 0, 'rewritten' => 0, 'missing' => 0];

        $query = $modelClass::query()->withoutGlobalScopes()->select([$model->getKeyName(), ...$columns]);

        if ($scope) {
            $scope($query);
        }

        $query->lazyById()->each(function (Model $row) use ($columns, $table) {
            $changedValues = [];

            foreach ($columns as $column) {
                $original = $row->getRawOriginal($column);

                if ($original === null) {
                    continue;
                }

                $rewritten = $this->rewriteContent($original, $table, $row->getKey());

                if ($rewritten !== $original) {
                    $changedValues[$column] = $rewritten;
                }
            }

            if (! $changedValues) {
                return;
            }

            $this->summary[$table]['rows']++;

            $changedColumns = implode(', ', array_keys($changedValues));

            $this->info("Rewriting `{$table}` #{$row->getKey()} ({$changedColumns})...");

            if ($this->option('dry-run')) {
                return;
            }

            $row->newQuery()->withoutGlobalScopes()->whereKey($row->getKey())->toBase()->update($changedValues);
        });
    }

    protected function rewriteContent(string $content, string $table, int|string $id): string
    {
        $segments = implode('|', array_map(
            fn (string $segment) => preg_quote($segment, '~'),
            array_keys($this->rewritableSegments()),
        ));

        $pattern = "~(?:(?:https?:)?//(?:www\\.)?freek\\.dev|(?<![\\w.:/-]))/({$segments})/([^\\s\"'()<>\\[\\]?#]+)~";

        return preg_replace_callback($pattern, function (array $matches) use ($table, $id) {
            [$url, $segment, $path] = $matches;

            $trailingPunctuation = '';

            if (preg_match('~[.,;:!]+$~', $path, $punctuation)) {
                $trailingPunctuation = $punctuation[0];
                $path = substr($path, 0, -strlen($trailingPunctuation));
            }

            if (! $this->existsInBucket($segment, rawurldecode($path))) {
                $this->summary[$table]['missing']++;

                $this->line("  Keeping `{$url}` in `{$table}` #{$id}, the file is not in the bucket.");

                return $url;
            }

            $this->summary[$table]['rewritten']++;

            return "{$this->bucketUrl}/{$segment}/{$path}{$trailingPunctuation}";
        }, $content);
    }

    /** @return array<string, string> */
    protected function rewritableSegments(): array
    {
        return collect(config('filesystems.asset_url_segments'))
            ->except('fonts')
            ->all();
    }

    protected function existsInBucket(string $segment, string $path): bool
    {
        $diskName = $this->rewritableSegments()[$segment];

        $this->filesPerDisk[$diskName] ??= array_fill_keys(Storage::disk($diskName)->allFiles(), true);

        return isset($this->filesPerDisk[$diskName][$path]);
    }
}
