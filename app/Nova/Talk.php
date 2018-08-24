<?php

namespace App\Nova;

use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Models\Talk as TalkModel;
use Laravel\Nova\Fields\Text;

class Talk extends Resource
{
    public static $model = TalkModel::class;

    public static $title = 'location';

    public static $search = ['title', 'location'];

    public function fields(Request $request)
    {
        return [
            Text::make('Title')->sortable(),

            Text::make('Location')->sortable(),

            Date::make('Presented at')->sortable(),

            Text::make('Video link')->hideFromIndex(),

            Text::make('Slides link')->hideFromIndex(),

            Text::make('Joindin link')->hideFromIndex(),
        ];
    }
}
