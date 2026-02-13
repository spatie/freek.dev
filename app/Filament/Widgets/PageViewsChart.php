<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Widgets\ChartWidget;

class PageViewsChart extends ChartWidget
{
    protected ?string $heading = 'Page Views Over Time';

    protected ?string $pollingInterval = null;

    protected ?string $maxHeight = '300px';

    public ?string $filter = '30';

    protected function getFilters(): ?array
    {
        return [
            '30' => 'Last 30 days',
            '180' => 'Last 6 months',
            '365' => 'Last year',
        ];
    }

    protected function getData(): array
    {
        $days = (int) $this->filter;
        $dailyData = app(AnalyticsService::class)->getDailyVisitors($days);

        return [
            'datasets' => [
                [
                    'label' => 'Page Views',
                    'data' => $dailyData->pluck('screenPageViews')->toArray(),
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                ],
                [
                    'label' => 'Active Users',
                    'data' => $dailyData->pluck('activeUsers')->toArray(),
                    'borderColor' => 'rgb(16, 185, 129)',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'fill' => true,
                ],
            ],
            'labels' => $dailyData->pluck('date')->map(fn ($date) => $date->format('M j'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
