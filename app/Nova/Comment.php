<?php

namespace App\Nova;

use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Comments\Models\Comment as CommentModel;

class Comment extends Resource
{
    public static $model = CommentModel::class;

    public static $search = [
        'id', 'text',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('title', function (CommentModel $comment) {
                return $comment->topLevel()->commentable?->commentableName() ?? 'Deleted...';
            })->readonly(),

            MorphTo::make('Commentator')->types([
                \App\Nova\User::class,
            ]),

            Markdown::make('Original text'),

            Text::make('', function (CommentModel $comment) {
                if (! $url = $comment?->commentUrl()) {
                    return '';
                }

                return "<a target=\"comment_preview\" href=\"{$url}\">Show</a>";

            })->asHtml(),

            DateTime::make('Created at'),
        ];
    }
}
