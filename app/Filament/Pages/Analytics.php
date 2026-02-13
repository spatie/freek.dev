<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AnalyticsOverviewStats;
use App\Filament\Widgets\PageViewsChart;
use App\Filament\Widgets\PopularPostsTable;
use App\Filament\Widgets\TopCountriesTable;
use App\Filament\Widgets\TopReferrersTable;
use Filament\Pages\Page;

class Analytics extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.analytics';

    protected function getHeaderWidgets(): array
    {
        return [
            AnalyticsOverviewStats::class,
            PageViewsChart::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            PopularPostsTable::class,
            TopReferrersTable::class,
            TopCountriesTable::class,
        ];
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 1;
    }

    public function getFooterWidgetsColumns(): int|array
    {
        return [
            'md' => 2,
            'xl' => 2,
        ];
    }
}
