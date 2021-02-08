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

                    return '<a target="freekdev_preview" href="' . url($this->published ? $this->url : $this->preview_url) . '">Show</a>';
                })->asHtml(),

                Markdown::make('Text')
                    ->rules('required'),

                Tags::make('Tags')->hideFromIndex(),

                DateTime::make('Publish date')
                    ->sortable(),
            ]),

            new Panel('Meta', [
                Text::make('External url')
                    ->hideFromIndex(),

                Boolean::make('Published'),

                Boolean::make('Original content'),

                Boolean::make('Send automated tweet')
                    ->hideFromIndex()
                    ->withMeta(['value' => $this->send_automated_tweet ?? true]),

                BelongsTo::make('Submitted by', 'submittedByUser', User::class)
                    ->hideFromIndex()
                    ->nullable(),

                Text::make('Author Twitter handle'),
            ]),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query
            ->orderBy('published')
            ->orderByDesc('publish_date');
    }
}
