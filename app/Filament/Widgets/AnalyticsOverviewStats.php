<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AnalyticsOverviewStats extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $stats = app(AnalyticsService::class)->getOverviewStats(30);

        return [
            Stat::make('Total Page Views', number_format($stats['totalPageViews']))
                ->description('Last 30 days')
                ->chart($stats['dailyPageViews'])
                ->color('primary'),
            Stat::make('Unique Visitors', number_format($stats['totalVisitors']))
                ->description('Last 30 days')
                ->chart($stats['dailyVisitors'])
                ->color('success'),
            Stat::make('Avg Daily Views', number_format($stats['avgDailyViews']))
                ->description('Last 30 days')
                ->color('warning'),
            Stat::make('Posts Published', (string) $stats['totalPostsPublished'])
                ->description('Last 30 days')
                ->color('info'),
        ];
    }
}
