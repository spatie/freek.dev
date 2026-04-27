<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PopularPostsTable extends BaseWidget
{
    protected ?string $pollingInterval = null;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.popular-posts-table';

    public string $days = '30';

    public function table(Table $table): Table
    {
        return $table
            ->heading(null)
            ->records(function (): array {
                $posts = app(AnalyticsService::class)->getMostVisitedPosts((int) $this->days, 50);

                return $posts
                    ->values()
                    ->map(fn (array $post, int $index) => [
                        'id' => $index + 1,
                        'rank' => $index + 1,
                        'title' => $post['postTitle'],
                        'url' => $post['postUrl'],
                        'pageViews' => $post['pageViews'],
                        'type' => $post['postType'],
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

    public function getFilters(): array
    {
        return [
            '30' => 'Last 30 days',
            '180' => 'Last 6 months',
            '365' => 'Last year',
        ];
    }
}
