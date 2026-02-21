<?php

namespace App\Filament\Resources\NewsletterTestimonials;

use App\Filament\Resources\NewsletterTestimonials\Pages\CreateNewsletterTestimonial;
use App\Filament\Resources\NewsletterTestimonials\Pages\EditNewsletterTestimonial;
use App\Filament\Resources\NewsletterTestimonials\Pages\ListNewsletterTestimonials;
use App\Filament\Resources\NewsletterTestimonials\Schemas\NewsletterTestimonialForm;
use App\Filament\Resources\NewsletterTestimonials\Tables\NewsletterTestimonialsTable;
use App\Models\NewsletterTestimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class NewsletterTestimonialResource extends Resource
{
    protected static ?string $model = NewsletterTestimonial::class;

    protected static ?string $navigationLabel = 'Testimonials';

    protected static ?int $navigationSort = 3;

    protected static string|\UnitEnum|null $navigationGroup = 'Other';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    public static function form(Schema $schema): Schema
    {
        return NewsletterTestimonialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NewsletterTestimonialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNewsletterTestimonials::route('/'),
            'create' => CreateNewsletterTestimonial::route('/create'),
            'edit' => EditNewsletterTestimonial::route('/{record}/edit'),
        ];
    }
}
