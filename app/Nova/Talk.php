<?php

namespace App\Nova;

use App\Models\Talk as TalkModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;

class Talk extends Resource
{
    public static $model = TalkModel::class;

    public static $title = 'location';

    public static $search = ['title', 'location'];

    public function fields(Request $request)
    {
        return [
            Text::make('Title')->sortable()->rules('required'),
            Text::make('Location')->sortable()->rules('required'),
            Date::make('Presented at')->sortable()->rules('required'),
            Text::make('Video link')->hideFromIndex(),
            Text::make('Slides link')->hideFromIndex(),
            Text::make('Joindin link')->hideFromIndex(),
        ];
    }
}
