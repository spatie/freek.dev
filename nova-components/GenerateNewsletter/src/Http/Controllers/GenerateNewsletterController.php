<?php

namespace Freekmurze\GenerateNewsletter\Http\Controllers;

use Carbon\Carbon;
use Freekmurze\GenerateNewsletter\NewsletterGenerator;
use Illuminate\Http\Request;

class GenerateNewsletterController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'editionNumber' => 'required|numeric',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
        ]);

        $startDate = Carbon::createFromFormat('Y-m-d', $validated['startDate']);
        $endDate = Carbon::createFromFormat('Y-m-d', $validated['endDate']);

        $newsletterHtml = (new NewsletterGenerator(
            $startDate,
            $endDate,
            $validated['editionNumber']
        )
        )->getHtml();

        return $newsletterHtml;
    }
}
