<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Discovery\Community\IndexController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController
{
    use AuthenticatesUsers, ValidatesRequests;

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/admin';
        }

        return '/community';
    }
}
