<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;
use Spatie\Mailcoach\Domain\Audience\Rules\EmailListSubscriptionRule;

class SubscribeToNewsletterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'email:rfc,dns', new EmailListSubscriptionRule($this->emailList())],
        ];
    }

    public function emailList(): EmailList
    {
        return EmailList::where('name', 'freek.dev newsletter')->first();
    }
}
