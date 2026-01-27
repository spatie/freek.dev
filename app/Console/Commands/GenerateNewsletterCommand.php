<?php

namespace App\Console\Commands;

use App\Actions\GenerateNewsletterAction;
use Illuminate\Console\Command;

class GenerateNewsletterCommand extends Command
{
    protected $signature = 'newsletter:generate';

    public function handle(GenerateNewsletterAction $action): int
    {
        $result = $action->execute();

        $this->info("freek.dev newsletter #{$result->editionNumber} has been created with posts from {$result->startDate->format('Y-m-d')} until {$result->endDate->format('Y-m-d')}!");
        $this->info("Mailcoach URL: {$result->getMailcoachUrl()}");

        return self::SUCCESS;
    }
}
