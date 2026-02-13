<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularPostsTable extends BaseWidget
{
    protected static ?string $heading = 'Most Popular Posts';

    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->records(function (): array {
                $pages = app(AnalyticsService::class)->getMostVisitedPages(30, 50);

                return $pages
                    ->filter(fn (array $page) => $page['postId'] !== null)
                    ->values()
                    ->map(fn (array $page, int $index) => [
                        'id' => $index + 1,
                        'rank' => $index + 1,
                        'title' => $page['postTitle'] ?? $page['pageTitle'],
                        'url' => $page['postUrl'] ?? $page['url'],
                        'pageViews' => $page['pageViews'],
                        'type' => $page['postType'] ?? 'unknown',
                    ])
                    ->toArray();
            })
            ->columns([
                TextColumn::make('rank')
                    ->label('#')
                    ->width('50px'),
                TextColumn::make('title')
                    ->label('Post Title')
                    ->url(fn (array $record): string => $record['url'] ?? '#', shouldOpenInNewTab: true)
                    ->limit(80),
                TextColumn::make('pageViews')
                    ->label('Page Views')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'originalPost' => 'success',
                        'link' => 'info',
                        default => 'gray',
                    }),
            ])
            ->paginated([10, 25, 50]);
    }
}
