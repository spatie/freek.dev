<?php

use App\Console\Commands\PublishScheduledPostsCommand;
use \Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

Schedule::command(RunHealthChecksCommand::class)->everyMinute();
Schedule::command(PublishScheduledPostsCommand::class)->everyMinute();
Schedule::command('responsecache:clear')->daily();
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run')->dailyAt('3:00');
Schedule::command('site-search:crawl')->daily();
Schedule::command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily();
