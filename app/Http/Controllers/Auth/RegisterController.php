<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Links\LinksIndexController;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Models\Subscriber;

class RegisterController
{
    use RegistersUsers, ValidatesRequests;

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'twitter_handle' => ['nullable', 'max:15', 'regex:/^[A-Za-z0-9_]+$/'],
        ], [
            'twitter_handle.max' => 'Your Twitter username may not be greater than 15 characters.',
            'twitter_handle.regex' => 'Your Twitter username may only contain letters, numbers and underscores.',
        ]);
    }

    protected function create(array $data)
    {
        if (isset($data['newsletter'])) {
            $emailList = EmailList::where('name', 'freek.dev newsletter')->first();

            Subscriber::createWithEmail($data['email'])->subscribeTo($emailList);
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'twitter_handle' => $data['twitter_handle'],
        ]);
    }

    public function redirectPath()
    {
        if (auth()->user()->admin) {
            return '/nova/posts';
        }

        return action(LinksIndexController::class);
    }
}
