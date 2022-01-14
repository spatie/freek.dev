<?php

namespace App\Http\Controllers\Discovery\Newsletter;

use App\Http\Requests\SubscribeToNewsletterRequest;
use Spatie\Honeypot\ProtectAgainstSpam;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;
use Spatie\RouteDiscovery\Attributes\Route;

class SubscribeController
{
    #[Route(method: 'post', middleware: ['doNotCacheResponse', ProtectAgainstSpam::class])]
    public function __invoke(SubscribeToNewsletterRequest $request)
    {
        $emailList = $request->emailList();

        Subscriber::createWithEmail($request->email)
            ->redirectAfterSubscribed(route('newsletter.confirmed'))
            ->subscribeTo($emailList);

        return redirect()->route('newsletter.confirm');
    }
}
