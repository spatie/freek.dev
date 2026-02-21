<?php

namespace App\Filament\Resources\NewsletterTestimonials\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class NewsletterTestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Forms\Components\Textarea::make('text')
                    ->required()
                    ->rows(3),
                Forms\Components\TextInput::make('author_name')
                    ->required(),
                Forms\Components\TextInput::make('author_title')
                    ->placeholder('e.g. Senior Developer at Acme'),
                Forms\Components\TextInput::make('author_url')
                    ->url()
                    ->placeholder('https://...'),
                Forms\Components\Placeholder::make('avatar_preview')
                    ->label('Avatar')
                    ->content(fn ($record) => $record?->avatar_url
                        ? new \Illuminate\Support\HtmlString('<img src="'.e($record->avatar_url).'" class="w-16 h-16 rounded-full object-cover">')
                        : 'No avatar')
                    ->visibleOn('edit'),
                Forms\Components\TextInput::make('avatar_url')
                    ->url()
                    ->placeholder('https://github.com/username.png')
                    ->helperText('Fallback URL if no uploaded avatar'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
