<?php

namespace App\Filament\Resources;

use App\Actions\FetchSharedTweetAction;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Rules\TweetUrl;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class PostResource extends Resource
{
    protected static ?int $navigationSort = 0;

    protected static string|\UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $model = Post::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Share a tweet')
                    ->description('Save a tweet with an optional comment. It will also appear in the newsletter for its publication period.')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('shared_tweet_url')
                            ->label('Tweet URL')
                            ->placeholder('https://x.com/username/status/…')
                            ->url()
                            ->maxLength(255)
                            ->rule(new TweetUrl)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set): void {
                                $set('shared_tweet_author', null);
                                $set('shared_tweet_text', null);
                            })
                            ->helperText('Paste an X or twitter.com link, then load the tweet. Leave empty for a regular post.')
                            ->columnSpanFull()
                            ->suffixAction(
                                Actions\Action::make('loadTweet')
                                    ->label('Load tweet')
                                    ->button()
                                    ->icon('heroicon-o-arrow-down-tray')
                                    ->action(function (Get $get, Set $set): void {
                                        try {
                                            $tweet = (new FetchSharedTweetAction)->execute($get('shared_tweet_url') ?? '');
                                        } catch (ValidationException $exception) {
                                            throw ValidationException::withMessages([
                                                'data.shared_tweet_url' => $exception->validator->errors()->first(),
                                            ]);
                                        }

                                        foreach ($tweet as $key => $value) {
                                            $set($key, $value);
                                        }

                                        if (! $get('title')) {
                                            $set('title', 'A thought from '.$tweet['shared_tweet_author']);
                                        }
                                    }),
                            ),
                        Forms\Components\TextInput::make('shared_tweet_author')
                            ->label('Tweet author')
                            ->placeholder('Jack Sharkey')
                            ->maxLength(255)
                            ->requiredWith('shared_tweet_url')
                            ->visible(fn (Get $get): bool => filled($get('shared_tweet_url'))),
                        Forms\Components\Textarea::make('shared_tweet_text')
                            ->label('Tweet text')
                            ->rows(6)
                            ->maxLength(20000)
                            ->requiredWith('shared_tweet_url')
                            ->helperText('Review before publishing: X may shorten long tweets. You can paste the full text here.')
                            ->columnSpanFull()
                            ->visible(fn (Get $get): bool => filled($get('shared_tweet_url'))),
                    ]),
                Section::make('Post')->schema([
                    Forms\Components\TextInput::make('title')->required(),
                    MarkdownEditor::make('text')
                        ->label(fn (Get $get): string => $get('shared_tweet_url') ? 'Your comment (optional)' : 'Text')
                        ->fileAttachmentsDisk('admin-uploads')
                        ->required(fn (Get $get): bool => ! $get('shared_tweet_url')),

                    Forms\Components\DateTimePicker::make('publish_date')
                        ->nullable(),
                    SpatieTagsInput::make('tags'),
                ]),
                Section::make('Meta')->schema([
                    Forms\Components\TextInput::make('external_url'),
                    Forms\Components\Checkbox::make('published'),
                    Forms\Components\Checkbox::make('original_content')
                        ->disabled(fn (Get $get): bool => filled($get('shared_tweet_url'))),
                    Forms\Components\Checkbox::make('send_automated_tweet')->default(true),
                    Forms\Components\Select::make('submitted_by_user_id')
                        ->relationship('submittedByUser', 'name'),
                    Forms\Components\TextInput::make('author_twitter_handle'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $table
            ->modifyQueryUsing(fn (Builder $query) => $query->orderByRaw('case when publish_date is null then 9999999999999999 else timestamp(publish_date) end desc'));

        return $table
            ->defaultPaginationPageOption(50)
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(60)
                    ->wrap()
                    ->tooltip(fn (Post $record): string => $record->title)
                    ->sortable(),

                Tables\Columns\TextColumn::make('formatted_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (Post $record): string => $record->isTweet() ? 'info' : 'gray'),

                Tables\Columns\TextColumn::make('publish_date')
                    ->dateTime('M j, Y H:i')
                    ->placeholder('Not scheduled'),
                Tables\Columns\IconColumn::make('published')->boolean(),
                Tables\Columns\IconColumn::make('external_url')->label('URL')->boolean(),
                Tables\Columns\IconColumn::make('original_content')->label('Original')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Actions\Action::make('preview')
                    ->url(fn (Post $record) => $record->adminPreviewUrl(), shouldOpenInNewTab: true),
                Actions\Action::make('schedule')->action(function (Post $post) {
                    if ($post->publish_date) {
                        return;
                    }

                    $post->update([
                        'publish_date' => Post::nextFreePublishDate(),
                    ]);
                }),
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
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
