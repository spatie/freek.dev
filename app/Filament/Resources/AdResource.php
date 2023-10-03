<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
use App\Models\Ad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Other';

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\MarkdownEditor::make('text')->required(),
                Forms\Components\TextInput::make('display_on_url'),
                Forms\Components\DatePicker::make('starts_at'),
                Forms\Components\DatePicker::make('ends_at'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')->limit(70)->sortable(),
                Tables\Columns\TextColumn::make('starts_at')->sortable()->date(),
                Tables\Columns\TextColumn::make('ends_at')->sortable()->date(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('starts_at', 'desc');
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
