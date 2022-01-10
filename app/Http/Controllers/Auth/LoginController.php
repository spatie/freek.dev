<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Discovery\Community\IndexController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController
{
    use ValidatesRequests, AuthenticatesUsers;

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova';
        }

        return action(IndexController::class);
    }
}
