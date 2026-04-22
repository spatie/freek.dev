<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class SyncProdAssets extends Command
{
    protected $signature = 'sync:prod-assets {manifest-url} {--limit=0 : Stop after N files}';

    protected $description = 'Download files listed in a JSON manifest and write them to the public disk.';

    public function handle(): int
    {
        $manifestUrl = $this->argument('manifest-url');
        $limit = (int) $this->option('limit');

        $this->info("Fetching manifest from {$manifestUrl}");
        $manifest = Http::timeout(30)->get($manifestUrl)->throw()->json();

        $total = count($manifest);
        $this->info("Manifest has {$total} entries");

        $disk = Storage::disk('public');
        $ok = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($manifest as $i => $entry) {
            if ($limit > 0 && $ok + $skipped >= $limit) {
                break;
            }

            $path = $entry['path'];
            $sourceUrl = $entry['url'];

            if ($disk->exists($path)) {
                $skipped++;
                continue;
            }

            try {
                $body = Http::timeout(60)->get($sourceUrl)->throw()->body();
                $disk->put($path, $body);
                $ok++;
            } catch (\Throwable $e) {
                $failed++;
                $this->warn("FAIL [{$i}] {$path}: {$e->getMessage()}");
                continue;
            }

            if (($ok + $skipped) % 25 === 0) {
                $this->info("progress: {$ok} new, {$skipped} skipped, {$failed} failed");
            }
        }

        $this->info("Done: {$ok} new, {$skipped} skipped, {$failed} failed");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
