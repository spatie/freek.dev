<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopReferrersTable extends BaseWidget
{
    protected static ?string $heading = 'Top Referrers';

    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->records(function (): array {
                $referrers = app(AnalyticsService::class)->getTopReferrers(30, 20);

                return $referrers
                    ->map(fn (array $referrer, int $index) => [
                        'id' => $index + 1,
                        'url' => $referrer['pageReferrer'] ?? '(direct)',
                        'pageViews' => $referrer['screenPageViews'] ?? 0,
                    ])
                    ->toArray();
            })
            ->columns([
                TextColumn::make('url')
                    ->label('Referrer')
                    ->url(fn (array $record): string => str_starts_with($record['url'], 'http')
                        ? $record['url']
                        : "https://{$record['url']}", shouldOpenInNewTab: true)
                    ->limit(60),
                TextColumn::make('pageViews')
                    ->label('Page Views')
                    ->numeric(),
            ])
            ->paginated(false)
            ->description('Last 30 days');
    }
}
