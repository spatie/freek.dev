<?php

namespace App\Filament\Resources\AdResource\Pages;

use App\Filament\Resources\AdResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAd extends EditRecord
{
    protected static string $resource = AdResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
