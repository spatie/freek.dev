<?php

namespace App\Http\Controllers\Front;

use App\Models\Talk;
use Illuminate\Routing\Controller;

class MeController extends Controller
{
    public function index()
    {
        $talks = Talk::orderBy('presented_at', 'desc')->get();

        return view('front.me.index', compact('talks'));
    }
}
