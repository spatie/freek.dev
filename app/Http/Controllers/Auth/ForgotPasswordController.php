<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ForgotPasswordController
{
    use ValidatesRequests, SendsPasswordResetEmails;
}
