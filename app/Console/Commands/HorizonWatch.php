<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Watcher\Watch;
use Symfony\Component\Process\Process;

class HorizonWatch extends Command
{
    protected Process $horizonProcess;

    protected $signature = 'horizon:watch';

    protected $description = 'Run Horizon and restart it when files are changes';

    public function handle()
    {
        $this->components->info('Starting Horizon and will restart it when any files change...');

        $horizonStarted = $this->startHorizon();

        if (! $horizonStarted) {
            return Command::FAILURE;
        }
            $this->listenForChanges();
    }

    protected function listenForChanges(): self
    {
        Watch::paths([app_path(), resource_path('views')])
            ->onAnyChange(function (string $event, string $path) {
                if ($this->isPhpFile($path)) {
                    $this->restartHorizon();
                }
            })


            ->start();

        return $this;
    }

    public function startHorizon(): bool
    {
        $this->horizonProcess = Process::fromShellCommandline('php artisan horizon');

        $this->horizonProcess->setTty(true)->setTimeout(null);

        $this->horizonProcess->start(fn($type, $output) => $this->info($output));

        sleep(1);

        return ! $this->horizonProcess->isTerminated();
    }

    public function restartHorizon(): self
    {
        $this->components->info('Change detected! Restarting horizon...');

        $this->horizonProcess->stop();

        $this->startHorizon();

        return $this;
    }

    protected function isPhpFile(string $path): bool
    {
        return str_ends_with(strtolower($path), '.php');
    }
}
