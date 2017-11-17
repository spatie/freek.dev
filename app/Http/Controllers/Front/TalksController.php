<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Talk;

class TalksController extends Controller
{
    public function index()
    {
        $talks = Talk::orderBy('presented_at', 'desc')->get();

        return view('front.talks.index', compact('talks'));
    }
}
