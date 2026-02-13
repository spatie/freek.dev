<?php

namespace App\Http\Controllers;

use App\Services\Music\Releases;
use Illuminate\View\View;

class MusicController
{
    public function __invoke(): View
    {
        $releases = Releases::all();

        return view('front.pages.music', compact('releases'));
    }
}
