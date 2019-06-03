<?php

namespace App\Http\Controllers;

use App\Models\Talk;
use App\Models\Video;

class SpeakerController
{
    public function __invoke()
    {
        $talks = Talk::orderBy('presented_at', 'desc')
            ->get()
            ->groupBy('title');

        $videos = Video::latest()->get();

        return view('front.speaker.index', compact('talks', 'videos'));
    }
}
