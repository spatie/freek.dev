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
                User::class,
            ]),

            Markdown::make('Original text'),

            Text::make('', function (CommentModel $comment) {
                if (! $url = $comment?->commentUrl()) {
                    return '';
                }

                return "<a target=\"show_comment\" href=\"{$url}\">Show</a>";
            })->asHtml(),

            Text::make('status', function (CommentModel $comment) {
                if ($comment->isApproved()) {
                    return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800'>Approved</div>";
                }

                return "<div class='inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800'>Pending</div>";
            })->asHtml(),

            DateTime::make('Created at'),
        ];
    }
}
