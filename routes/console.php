<?php

use App\Console\Commands\PublishScheduledPostsCommand;
use App\Jobs\FetchPopularPostsJob;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

Schedule::command(RunHealthChecksCommand::class)->everyMinute()->graceTimeInMinutes(3);
Schedule::command(PublishScheduledPostsCommand::class)->everyMinute()->graceTimeInMinutes(3);
Schedule::command('responsecache:clear')->daily();
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->dailyAt('3:00');
Schedule::command('site-search:crawl')->daily()->graceTimeInMinutes(10);
Schedule::command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily()->graceTimeInMinutes(10);
Schedule::job(new FetchPopularPostsJob)->twiceDaily(4, 16);
