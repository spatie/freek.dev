<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Services\Newsletter\Generator;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsletterGeneratorController extends Controller
{
    public function index()
    {
        $newsletterHtml = session('newsletterHtml');

        return view('back.newsletterGenerator.index', compact('newsletterHtml'));
    }

    public function generate(Request $request)
    {
        $attributes = $request->validate([
            'edition_number' => 'required|numeric',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        $endDate = Carbon::createFromFormat('Y-m-d', $attributes['end_date']);

        $newsletterHtml = (new Generator($endDate, $attributes['edition_number']))->getHtml();

        session()->flash('newsletterHtml', $newsletterHtml);

        return back();
    }
}
