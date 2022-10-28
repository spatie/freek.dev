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
        $this->info('Starting Horizon and will restart it when any files change...');

        $this->trap([SIGTERM, SIGQUIT], fn () => $this->info('👋 Stopping Horizon'));

        $this
            ->startHorizon()
            ->listenForChanges();
    }

    protected function listenForChanges(): self
    {
        Watch::paths([app_path(), resource_path('views')])
            ->onAnyChange(fn () => $this->restartHorizon())
            ->start();

        return $this;
    }

    public function startHorizon(): self
    {
        $this->horizonProcess = Process::fromShellCommandline('php artisan horizon');

        $this->horizonProcess->setTty(true)->setTimeout(null);

        $this->horizonProcess->start(fn ($type, $output) => $this->info($output));

        return $this;
    }

    public function restartHorizon(): self
    {
        $this->comment('Change detected... Restarting horizon');

        $this->horizonProcess->stop();

        $this->startHorizon();

        return $this;
    }
}
