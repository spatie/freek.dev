<?php

namespace App\Filament\Resources\NewsletterTestimonials\Pages;

use App\Filament\Resources\NewsletterTestimonials\NewsletterTestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterTestimonial extends EditRecord
{
    protected static string $resource = NewsletterTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
