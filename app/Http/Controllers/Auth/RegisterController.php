<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Discovery\Community\IndexController;
use App\Models\User;
use App\Services\Mailcoach;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController
{
    use RegistersUsers, ValidatesRequests;

    protected function validator(array $data)
    {
        $passwordRules = ['required', 'string', 'confirmed'];

        if (app()->environment('production')) {
            $passwordRules[] = Password::min(8)->uncompromised();
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $passwordRules,
            'twitter_handle' => ['nullable', 'max:15', 'regex:/^[A-Za-z0-9_]+$/'],
        ], [
            'twitter_handle.max' => 'Your Twitter username may not be greater than 15 characters.',
            'twitter_handle.regex' => 'Your Twitter username may only contain letters, numbers and underscores.',
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'twitter_handle' => $data['twitter_handle'],
        ]);

        $user->sendEmailVerificationNotification();

        if (isset($data['newsletter'])) {
            Mailcoach::post('/email-lists/'.config('services.mailcoach.email_list_uuid').'/subscribers', ['email' => $user->email]);
        }

        return $user;
    }

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova/posts';
        }

        return action(IndexController::class);
    }
}
