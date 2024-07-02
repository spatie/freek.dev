<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use App\Models\Post;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')->url($this->record->adminPreviewUrl(), shouldOpenInNewTab: true),
            Action::make('schedule')->action(function(Post $post) {
                if ($post->publish_date) {
                    return;
                }

                $post->update([
                    'publish_date' => Post::nextFreePublishDate(),
                ]);

                $this->redirect(back()->getTargetUrl());
            }),
            DeleteAction::make(),
        ];
    }
}
