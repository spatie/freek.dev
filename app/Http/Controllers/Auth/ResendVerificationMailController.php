<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Discovery\Community\IndexController;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class ResendVerificationMailController
{
    public function __invoke()
    {
        auth()->user()->sendEmailVerificationNotification();

        flash()->success('Verification email sent!');

        return back();
    }
}
