<?php

namespace App\Filament\Widgets;

use App\Services\AnalyticsService;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopCountriesTable extends BaseWidget
{
    protected static ?string $heading = 'Top Countries';

    protected ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        return $table
            ->records(function (): array {
                $countries = app(AnalyticsService::class)->getTopCountries(30, 15);

                return $countries
                    ->map(fn (array $country, int $index) => [
                        'id' => $index + 1,
                        'country' => $country['country'] ?? 'Unknown',
                        'pageViews' => $country['screenPageViews'] ?? 0,
                    ])
                    ->toArray();
            })
            ->columns([
                TextColumn::make('country')
                    ->label('Country'),
                TextColumn::make('pageViews')
                    ->label('Page Views')
                    ->numeric(),
            ])
            ->paginated(false)
            ->description('Last 30 days');
    }
}
