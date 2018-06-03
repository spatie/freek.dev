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
        $validated = $request->validate([
            'edition_number' => 'required|numeric',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $validated['start_date']);
        $endDate = Carbon::createFromFormat('Y-m-d', $validated['end_date']);

        $newsletterHtml = (new Generator(
            $startDate,
            $endDate,
            $validated['edition_number'])
        )->getHtml();

        session()->flash('newsletterHtml', $newsletterHtml);

        return redirect()->action('Back\NewsletterGeneratorController@index');
    }
}
