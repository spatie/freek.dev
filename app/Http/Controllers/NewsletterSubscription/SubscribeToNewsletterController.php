<?php

namespace App\Http\Controllers\NewsletterSubscription;

use App\Http\Requests\SubscribeToNewsletterRequest;

class SubscribeToNewsletterController
{
    public function __invoke(SubscribeToNewsletterRequest $request)
    {
        $emailList = $request->emailList();

        $emailList->subscribe($request->email);

        return redirect()->action(ConfirmNewsletterSubscriptionController::class);
    }
}
