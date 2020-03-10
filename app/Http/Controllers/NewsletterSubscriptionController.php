<?php

namespace App\Http\Controllers;

use Spatie\Mailcoach\Models\Subscriber;

class NewsletterSubscriptionController
{
    public function subscribe($request)
    {
        info('in subscribe');
        dd('test');

        $emailList = $request->emailList();

        Subscriber::createWithEmail($request->email)
            ->redirectAfterSubscribed(action([static::class, 'confirmed']))
            ->subscribeTo($emailList);

        return redirect()->action([static::class, 'confirm']);
    }

    public function confirm()
    {
        return view('front.newsletter.confirm');
    }

    public function confirmed()
    {
        return view('front.newsletter.confirmed');
    }
}
