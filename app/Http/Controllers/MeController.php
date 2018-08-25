<?php

namespace App\Http\Controllers;

use App\Models\Talk;

class MeController extends Controller
{
    public function index()
    {
        $talks = Talk::orderBy('presented_at', 'desc')->get();

        return view('front.me.index', compact('talks'));
    }
}
