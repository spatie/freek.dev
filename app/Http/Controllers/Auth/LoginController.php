<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Links\LinksIndexController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController
{
    use ValidatesRequests;

    use AuthenticatesUsers;

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova/posts';
        }

        return action(LinksIndexController::class);
    }
}
