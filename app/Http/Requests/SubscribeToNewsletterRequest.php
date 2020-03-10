<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Mailcoach\Models\EmailList;
use Spatie\Mailcoach\Rules\EmailListSubscriptionRule;

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
