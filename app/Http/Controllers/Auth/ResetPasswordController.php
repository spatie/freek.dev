<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ResetPasswordController
{
    use ResetsPasswords, ValidatesRequests;

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/admin';
        }

        return redirect()->to('/community');
    }
}
