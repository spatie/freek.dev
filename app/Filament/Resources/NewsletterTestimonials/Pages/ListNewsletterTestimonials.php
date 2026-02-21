<?php

namespace App\Filament\Resources\NewsletterTestimonials\Pages;

use App\Filament\Resources\NewsletterTestimonials\NewsletterTestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNewsletterTestimonials extends ListRecords
{
    protected static string $resource = NewsletterTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
