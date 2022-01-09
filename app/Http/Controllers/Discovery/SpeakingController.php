<?php

namespace App\Http\Controllers\Discovery;

use App\Models\Talk;
use App\Models\Video;

class SpeakingController
{
    public function __invoke()
    {
        $talks = Talk::orderBy('presented_at', 'desc')
            ->get()
            ->groupBy('title');

        $videos = Video::latest()->get();

        return view('front.speaking.index', compact('talks', 'videos'));
    }
}
