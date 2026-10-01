<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileAttributes;
use Throwable;

#[Signature('app:backup-assets')]
#[Description('Copy new and changed assets from object storage to the backups disk, never deleting anything')]
class BackupAssetsCommand extends Command
{
    public function handle(): int
    {
        $assetsDisk = Storage::disk('object-storage');
        $backupsDisk = Storage::disk('backups');

        $backedUpFileSizes = $this->fileSizes($backupsDisk, 'assets');

        $filesToCopy = $this->fileSizes($assetsDisk)
            ->reject(fn (int $size, string $path) => $backedUpFileSizes->get("assets/{$path}") === $size);

        $this->info("Copying {$filesToCopy->count()} files...");

        $failures = 0;

        foreach ($filesToCopy->keys() as $path) {
            $this->comment("Copying `{$path}`...");

            try {
                $backupsDisk->writeStream("assets/{$path}", $assetsDisk->readStream($path));
            } catch (Throwable $exception) {
                $failures++;

                $this->error("Failed to copy `{$path}`: {$exception->getMessage()}");
            }
        }

        $this->info("Copied {$filesToCopy->count()} files, {$failures} failed.");

        return $failures === 0 ? self::SUCCESS : self::FAILURE;
    }

    /** @return Collection<string, int> */
    protected function fileSizes(Filesystem $disk, string $directory = ''): Collection
    {
        return collect($disk->getDriver()->listContents($directory, deep: true))
            ->filter(fn ($item) => $item instanceof FileAttributes)
            ->mapWithKeys(fn (FileAttributes $file) => [$file->path() => (int) $file->fileSize()]);
    }
}
