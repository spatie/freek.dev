<?php

use App\Console\Commands\BackupAssetsCommand;
use App\Console\Commands\PublishScheduledPostsCommand;
use App\Jobs\FetchPopularPostsJob;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

/*
 * Laravel Cloud wakes a hibernating app for every scheduled task, so nothing runs every minute.
 * Scheduled posts can be published up to 10 minutes after their publish date.
 */
Schedule::command(RunHealthChecksCommand::class)->everyTenMinutes()->graceTimeInMinutes(5);
Schedule::command(PublishScheduledPostsCommand::class)->everyTenMinutes()->graceTimeInMinutes(5);
Schedule::command('responsecache:clear')->daily();

Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run', laravel_cloud() ? ['--only-db'] : [])->dailyAt('3:00');

if (config('filesystems.assets_on_object_storage')) {
    Schedule::command(BackupAssetsCommand::class)->dailyAt('3:30')->runInBackground()->graceTimeInMinutes(30);
}

/*
 * The crawl takes about 25 minutes, longer than Laravel Cloud's managed queues allow,
 * so on Laravel Cloud it runs inside the scheduler instead of on a queue.
 * It runs weekly on Monday at 2:00, the hour with the least traffic.
 */
$crawlSiteSearch = Schedule::command('site-search:crawl', laravel_cloud() ? ['--sync'] : [])
    ->weeklyOn(1, '2:00')
    ->withoutOverlapping()
    ->graceTimeInMinutes(10);

if (laravel_cloud()) {
    $crawlSiteSearch->runInBackground()->graceTimeInMinutes(45);
}

Schedule::command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily()->graceTimeInMinutes(10);
Schedule::job(new FetchPopularPostsJob)->twiceDaily(4, 16);
Schedule::command('newsletter:sync-campaigns')->hourly()->graceTimeInMinutes(10);
