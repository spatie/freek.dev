<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostResource extends Resource
{
    protected static ?int $navigationSort = 0;

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Post')->schema([
                    Forms\Components\TextInput::make('title')->required(),
                    MarkdownEditor::make('text')
                        ->fileAttachmentsDisk('admin-uploads')
                        ->fileAttachmentsVisibility('public')
                        ->required(),

                    Forms\Components\DateTimePicker::make('publish_date')
                        ->withoutSeconds()
                        ->nullable(),
                    SpatieTagsInput::make('tags'),
                ]),
                Forms\Components\Section::make('Meta')->schema([
                    Forms\Components\TextInput::make('external_url'),
                    Forms\Components\Checkbox::make('published'),
                    Forms\Components\Checkbox::make('original_content'),
                    Forms\Components\Checkbox::make('send_automated_tweet'),
                    Forms\Components\Select::make('submitted_by_user_id')
                        ->relationship('submittedByUser', 'name'),
                    Forms\Components\TextInput::make('author_twitter_handle'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        Post::addGlobalScope('order', function (Builder $query) {
            $query->orderByRaw('case when publish_date is null then 9999999999999999 else timestamp(publish_date) end desc');
        });

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->limit(70)->sortable(),
                Tables\Columns\TextColumn::make('publish_date')
                    ->dateTime(),
                Tables\Columns\IconColumn::make('published')->boolean(),
                Tables\Columns\IconColumn::make('original_content')->label('Original')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('preview')
                    ->url(fn (Post $record) => $record->adminPreviewUrl(), shouldOpenInNewTab: true),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->title;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'text'];
    }
}
