<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\MailCoach\Models\EmailList;
use Spatie\MailCoach\Rules\EmailListSubscriptionRule;

class SubscribeToNewsletterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email', new EmailListSubscriptionRule($this->emailList())],
        ];
    }

    public function emailList(): EmailList
    {
        return EmailList::where('name', 'freek.dev newsletter')->first();
    }
}
