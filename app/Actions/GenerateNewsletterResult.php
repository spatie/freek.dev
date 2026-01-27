<?php

namespace App\Actions;

use Illuminate\Support\Carbon;
use Spatie\MailcoachSdk\Resources\Campaign;

readonly class GenerateNewsletterResult
{
    public function __construct(
        public Campaign $campaign,
        public int $editionNumber,
        public Carbon $startDate,
        public Carbon $endDate,
    ) {}

    public function getMailcoachUrl(): string
    {
        $endpoint = rtrim(config('mailcoach-sdk.endpoint'), '/');

        return "{$endpoint}/campaigns/{$this->campaign->uuid}";
    }
}
