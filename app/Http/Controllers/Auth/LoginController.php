<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController
{
    use AuthenticatesUsers, ValidatesRequests;

    public function redirectPath(): string
    {
        if (auth()->user()->admin) {
            return '/admin';
        }

        return '/community';
    }
}
