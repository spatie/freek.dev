<?php

namespace App\Filament\Resources\TalkResource\Pages;

use App\Filament\Resources\TalkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTalks extends ListRecords
{
    protected static string $resource = TalkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
