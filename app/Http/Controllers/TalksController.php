<?php

namespace App\Http\Controllers;

use App\Models\Talk;

class TalksController
{
    public function __invoke()
    {
        $talks = Talk::orderBy('presented_at', 'desc')
            ->get()
            ->groupBy('title');

        return view('front.talks.index', compact('talks'));
    }
}
