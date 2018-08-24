<?php

namespace App\Nova;

use Laravel\Nova\Fields\Boolean;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use App\Models\Post as PostModel;
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
                Text::make('Title')->sortable(),

                Markdown::make('Text'),

                Tags::make('Tags'),

                Date::make('Publish date')->sortable(),
            ]),


            new Panel('Meta', [

                Text::make('External url')->hideFromIndex(),

                Boolean::make('Published'),

                Boolean::make('Original content'),
            ]),
        ];
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderByDesc('publish_date');
    }
}
