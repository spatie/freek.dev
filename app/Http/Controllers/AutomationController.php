<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscribeToAutomationRequest;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class AutomationController
{
    public function index()
    {
        return view('front.automation.index');
    }

    public function subscribe(SubscribeToAutomationRequest $request)
    {
        Subscriber::createWithEmail($request->email)
            ->subscribeTo($request->emailList());

        flash()->success('Thank you for helping me test this out!');

        return back();
    }
}
