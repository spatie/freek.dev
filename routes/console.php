<?php

use App\Console\Commands\PublishScheduledPostsCommand;
use App\Jobs\FetchPopularPostsJob;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

Schedule::command(RunHealthChecksCommand::class)->everyMinute()->graceTimeInMinutes(3);
Schedule::command(PublishScheduledPostsCommand::class)->everyMinute()->graceTimeInMinutes(3);
Schedule::command('responsecache:clear')->daily();

if (! laravel_cloud()) {
    Schedule::command('backup:clean')->daily()->at('01:00');
    Schedule::command('backup:run')->dailyAt('3:00');
}

/*
 * The crawl takes about 25 minutes, longer than Laravel Cloud's managed queues allow,
 * so on Laravel Cloud it runs inside the scheduler instead of on a queue.
 * It runs at 2:00, the hour with the least traffic.
 */
$crawlSiteSearch = Schedule::command('site-search:crawl', laravel_cloud() ? ['--sync'] : [])
    ->dailyAt('2:00')
    ->withoutOverlapping()
    ->graceTimeInMinutes(10);

if (laravel_cloud()) {
    $crawlSiteSearch->runInBackground()->graceTimeInMinutes(45);
}

Schedule::command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily()->graceTimeInMinutes(10);
Schedule::job(new FetchPopularPostsJob)->twiceDaily(4, 16);
Schedule::command('newsletter:sync-campaigns')->hourly()->graceTimeInMinutes(10);
