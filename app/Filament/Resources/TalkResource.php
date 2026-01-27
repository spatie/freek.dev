<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TalkResource\Pages;
use App\Models\Talk;
use Filament\Actions;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class TalkResource extends Resource
{
    protected static ?string $model = Talk::class;

    protected static ?int $navigationSort = 2;

    protected static string|\UnitEnum|null $navigationGroup = 'Other';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-presentation-chart-bar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('title')->required(),
                Forms\Components\TextInput::make('location')->required(),
                Forms\Components\DatePicker::make('presented_at')->required(),
                Forms\Components\TextInput::make('video_link'),
                Forms\Components\TextInput::make('slides_link'),
                Forms\Components\TextInput::make('joindin_link'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->sortable(),
                Tables\Columns\TextColumn::make('location')->sortable(),
                Tables\Columns\TextColumn::make('presented_at')->date()->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('presented_at', 'desc');
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
            'index' => Pages\ListTalks::route('/'),
            'create' => Pages\CreateTalk::route('/create'),
            'edit' => Pages\EditTalk::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'location'];
    }
}
