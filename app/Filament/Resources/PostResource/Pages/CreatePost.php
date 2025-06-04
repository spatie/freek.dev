<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions\Action;

class CreatePost extends CreateRecord
{
    protected bool $isScheduling = false;

    protected static string $resource = PostResource::class;

    protected function getFormActions(): array
    {
        return [
            Action::make('Create and schedule')->action('createAndSchedule'),
            ...parent::getFormActions(),
        ];
    }

    public function createAndSchedule(): void
    {
        $this->isScheduling = true;

        try {
            $this->create();
        } finally {
            $this->isScheduling = false;
        }
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($this->isScheduling) {
            $data['publish_date'] = Post::nextFreePublishDate();
        }

        return $data;
    }


}
