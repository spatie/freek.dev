<?php

namespace App\Nova;

use App\Models\Post as PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Spatie\TagsField\Tags;

class Post extends Resource
{
    public static $model = PostModel::class;

    public static $title = 'title';

    public static $search = [
        'title',
        'text',
    ];

    public function fields(Request $request)
    {
        return [
            new Panel('Post', [
                Text::make('Title')
                    ->sortable()
                    ->rules('required')
                    ->displayUsing(function (string $title) {
                        return Str::limit($title, 50);
                    }),

                Text::make('', function () {
                    if (! $this->exists) {
                        return '';
                    }

                    return '<a target="murze_preview" href="' . url($this->url) . '">Show</a>';
                })->asHtml(),

                Markdown::make('Text')
                    ->rules('required'),

                Tags::make('Tags'),

                DateTime::make('Publish date')
                    ->hideFromIndex()
                    ->sortable()
            ]),

            new Panel('Meta', [
                Text::make('External url')
                    ->hideFromIndex(),

                Boolean::make('Published'),

                Boolean::make('Original content'),

                BelongsTo::make('Submitted by', 'submittedByUser', User::class)
                    ->hideFromIndex()
                    ->nullable(),
            ]),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderByDesc('publish_date');
    }
}
