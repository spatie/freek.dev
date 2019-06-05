<?php

namespace App\Nova;

use App\Models\Video as VideoModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class Video extends Resource
{
    public static $model = VideoModel::class;

    public static $title = 'title';

    public static $search = ['title', 'text'];

    public function fields(Request $request)
    {
        return [
            Text::make('Title')
                ->sortable()
                ->rules('required'),

            Markdown::make('Text')
                ->hideFromIndex()
                ->rules('required'),

            Textarea::make('Embed')
                ->hideFromIndex()
                ->rules('required'),

            DateTime::make('Created at')
                ->hideFromIndex()
                ->sortable()
        ];
    }
}
