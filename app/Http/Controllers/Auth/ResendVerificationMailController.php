<?php

namespace App\Http\Controllers\Auth;

class ResendVerificationMailController
{
    public function __invoke()
    {
        auth()->user()->sendEmailVerificationNotification();

        flash()->success('Verification email sent!');

        return back();
    }
}
