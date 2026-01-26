<?php

namespace App\Filament\Resources\VideoResource\Pages;

use App\Filament\Resources\VideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideos extends ListRecords
{
    protected static string $resource = VideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
