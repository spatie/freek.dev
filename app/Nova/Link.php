<?php

namespace App\Nova;

use App\Models\Link as LinkModel;
use App\Nova\Actions\ApproveLink;
use App\Nova\Actions\RejectLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Link extends Resource
{
    public static $model = LinkModel::class;

    public static $title = 'title';

    public static $search = [
        'title',
        'url',
        'text',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Title')
                ->sortable()
                ->rules('required')
                ->displayUsing(function (string $title) {
                    return Str::limit($title, 50);
                }),

            Text::make('Url')
                ->hideFromIndex(),

            Text::make('', function () {
                if (! $this->exists) {
                    return '';
                }

                return '<a target="link_preview" href="' . url($this->url) . '">Show</a>';
            })->asHtml(),

            Text::make('Status')->readonly(),

            Markdown::make('Text')
                ->rules('required')
                ->alwaysShow()
                ->hideFromIndex(),

            DateTime::make('Created at'),
        ];
    }

    public function actions(Request $request)
    {
        return [
            (new ApproveLink)
                ->confirmText('Are you sure you want to approve this link?')
                ->confirmButtonText('Approve')
                ->cancelButtonText("Don't approve")
                ->onlyOnDetail()
                ->canSee(function () use ($request) {
                    $model = $this->getModel();

                    return $model
                        ? $this->getModel()->status === LinkModel::STATUS_SUBMITTED
                        : true;
                }),

            (new RejectLink())
                ->confirmText('Are you sure you want to reject this link?')
                ->confirmButtonText('Reject')
                ->cancelButtonText("Don't reject")
                ->onlyOnDetail()
                ->canSee(function () {
                    $model = $this->getModel();

                    return $model
                        ? $this->getModel()->status === LinkModel::STATUS_SUBMITTED
                        : true;
                }),
        ];
    }

    public function getModel(): ?LinkModel
    {
        if (! request()->resourceId) {
            return null;
        }

        return LinkModel::find(request()->resourceId);
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('status', '<>', LinkModel::STATUS_REJECTED)->latest();
    }
}
