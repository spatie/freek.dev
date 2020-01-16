<?php

namespace App\Nova\Actions;

use App\Actions\ApproveLinkAction;
use App\Models\Link;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ApproveLink extends Action
{
    use InteractsWithQueue, Queueable;

    public function handle(ActionFields $fields, Collection $models)
    {
        $models->each(function (Link $link) {
            (new ApproveLinkAction())->execute($link);
        });

        return Action::message('The link was approved!');
    }
}
