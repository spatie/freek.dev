<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Discovery\Community\IndexController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResetPasswordController
{
    use ResetsPasswords, ValidatesRequests;

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova';
        }

        return redirect()->to(action(IndexController::class));
    }
}
