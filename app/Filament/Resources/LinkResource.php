<?php

namespace App\Filament\Resources;

use App\Enums\LinkStatus;
use App\Filament\Resources\LinkResource\Pages;
use App\Models\Link;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class LinkResource extends Resource
{
    protected static ?string $model = Link::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 1;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-link';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Forms\Components\TextInput::make('title'),
                Forms\Components\TextInput::make('url'),
                Forms\Components\TextInput::make('status')->disabled(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(70)->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'bg-gray-200' => static fn ($state): bool => $state === LinkStatus::Submitted->value,
                        'success' => static fn ($state): bool => $state === LinkStatus::Approved->value,
                        'danger' => static fn ($state): bool => $state === LinkStatus::Rejected->value,
                    ]),

                Tables\Columns\TextColumn::make('created_at')->limit(50)->dateTime()->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\Action::make('preview')
                    ->url(fn (Link $record) => $record->url, shouldOpenInNewTab: true),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLinks::route('/'),
            'create' => Pages\CreateLink::route('/create'),
            'edit' => Pages\EditLink::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }
}
