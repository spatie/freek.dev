<?php

namespace App\Http\Components;

use App\Models\Ad;
use Illuminate\View\Component;

class AdComponent extends Component
{
    public function render()
    {
        $ad = Ad::getForCurrentPage();

        return view('components.ad', compact('ad'));
    }
}
