<?php

namespace App\Http\Controllers;

use Freekmurze\GenerateNewsletter\NewsletterGenerator;

class NewsletterTestController
{
    public function __invoke()
    {
        $startDate = now()->subWeek();
        $endDate = now();
        $editionNumber = 90;

        return (new NewsletterGenerator(
            $startDate,
            $endDate,
            $editionNumber,
        ))->getHtml();
    }
}
