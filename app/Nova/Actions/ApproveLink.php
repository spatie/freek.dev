<?php

namespace App\Nova\Actions;

use App\Actions\ApproveLinkAction;
use App\Actions\CreatePostFromLinkAction;
use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;

class ApproveLink extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Link $link) use ($fields) {
            (new ApproveLinkAction())->execute($link);

            if ($fields->also_create_post) {
                (new CreatePostFromLinkAction())->execute($link);
            }
        });

        return Action::message('The link was approved!');
    }

    public function fields()
    {
        return [
            Boolean::make('Also create post')
        ];
    }
}
